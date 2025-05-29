from geopy.geocoders import GoogleV3
from time import sleep
from tqdm import tqdm
import json
from scinetextractor import Library

def build_geocode_cache_from_library(
    library,
    api_key,
    cache_file="geocode_cache.json",
    delay=1
):
    """
    Geocodes authors' addresses using Google Maps API (fallback to university if address missing).
    Caches structured results: house_number, road, city, county, state, country, postcode, university, lat, lng.
    Does NOT modify the Library.
    """
    geolocator = GoogleV3(api_key=api_key)
    cache = {}

    try:
        with open(cache_file, "r") as f:
            cache = json.load(f)
    except FileNotFoundError:
        pass

    for author in tqdm(library.authors.values(), desc="Geocoding authors"):
        address = author.data.get("address", "").strip()
        university = author.data.get("university", "").strip()

        query_term = address if address else university

        if not query_term or query_term in cache:
            continue

        try:
            loc = geolocator.geocode(query_term)
            components = {}

            # Parse Google's address_components into a usable dict
            if loc and "address_components" in loc.raw:
                for item in loc.raw["address_components"]:
                    for t in item["types"]:
                        components[t] = item["long_name"]

            result = {
                "house_number": components.get("street_number", ""),
                "road": components.get("route", ""),
                "city": components.get("locality", "") or components.get("postal_town", ""),
                "county": components.get("administrative_area_level_2", ""),
                "state": components.get("administrative_area_level_1", ""),
                "country": components.get("country", ""),
                "postcode": components.get("postal_code", ""),
                "university": university,
                "lat": loc.latitude if loc else None,
                "lng": loc.longitude if loc else None
            }

            cache[query_term] = result

        except Exception as e:
            print(f"Error geocoding '{query_term}': {e}")
            cache[query_term] = {
                "house_number": "",
                "road": "",
                "city": "",
                "county": "",
                "state": "",
                "country": "",
                "postcode": "",
                "university": university,
                "lat": None,
                "lng": None
            }

        sleep(delay)

    with open(cache_file, "w", encoding="utf-8") as f:
        json.dump(cache, f, indent=2, ensure_ascii=False)

    print(f"Geocoding complete: {len(cache)} unique locations cached.")

def apply_geocode_cache_to_library(
    library,
    cache_file="geocode_cache.json"
):
    """
    Updates author metadata in the Library using a precomputed geocode cache.
    Fields added to each author.data: geo_* fields and lat/lng.
    """
    try:
        with open(cache_file, "r", encoding="utf-8") as f:
            cache = json.load(f)
    except FileNotFoundError:
        print(f"Geocode cache not found: {cache_file}")
        return

    updated = 0

    for author in library.authors.values():
        address = author.data.get("address", "").strip()
        university = author.data.get("university", "").strip()
        query_term = address if address else university

        if not query_term:
            continue

        data = cache.get(query_term)
        if not data:
            continue

        author.data.update({
            "geo_house_number": data.get("house_number", ""),
            "geo_road": data.get("road", ""),
            "geo_city": data.get("city", ""),
            "geo_county": data.get("county", ""),
            "geo_state": data.get("state", ""),
            "geo_country": data.get("country", ""),
            "geo_postcode": data.get("postcode", ""),
            "geo_university": data.get("university", ""),
            "lat": data.get("lat"),
            "lng": data.get("lng")
        })

        updated += 1

    print(f"Updated {updated} authors with geocoded data.")

def resave_geocode_cache_utf8(input_file="geocode_cache.json", output_file=None):
    """
    Reads a geocode cache file using fallback encoding detection and re-saves as UTF-8 JSON.
    """
    if output_file is None:
        output_file = input_file

    encodings_to_try = ["utf-8", "utf-8-sig", "cp1252", "latin-1"]

    with open(input_file, "rb") as f:
        raw_bytes = f.read()

    for encoding in encodings_to_try:
        try:
            text = raw_bytes.decode(encoding)
            data = json.loads(text)
            print(f"Decoded using encoding: {encoding}")
            break
        except (UnicodeDecodeError, json.JSONDecodeError):
            continue
    else:
        print("❌ Failed to decode file with common encodings.")
        return

    with open(output_file, "w", encoding="utf-8") as f:
        json.dump(data, f, indent=2, ensure_ascii=False)

    print(f"✅ Re-saved '{output_file}' in UTF-8 with readable Unicode.")

if __name__ == "__main__":
    lib = Library.load("./mto/mto_library.json", link_data=True)
    # build_geocode_cache_from_library(
    #     library=lib,
    #     api_key="AIzaSyAxYrhzu8e7a8cVbpJxiomXjtWkpxGHtvc",
    #     cache_file="geocode_cache.json"
    # )
    # resave_geocode_cache_utf8("geocode_cache.json")
    apply_geocode_cache_to_library(lib, cache_file="geocode_cache.json")
    lib.save()