"""Utility functions for the package."""

import os
import re
import sys
import logging.config

from typing import List

# Official workaround: https://github.com/hukkin/tomli
if sys.version_info >= (3, 11):
    import tomllib
else:
    import tomli as tomllib


# path to the module
path = str(os.path.dirname(sys.modules[__name__].__file__))  # type: ignore

# default config file name
configfile_name = "config.toml"

# check if local config file is defined
if not os.path.isfile(configfile_name):
    # get location of default config file
    configfile_name = os.path.join(path, configfile_name)

# load config file
with open(configfile_name, "rb") as f:
    config = tomllib.load(f)


# default logging config file name
loggingfile_name = "logging.toml"

# check if local logging config file is defined
if not os.path.isfile(loggingfile_name):
    # get location of default config file
    loggingfile_name = os.path.join(path, loggingfile_name)

# update logging confing
logging.config.fileConfig(loggingfile_name)

# create logger
logger = logging.getLogger("scinetextractor")

# Status message of the logger
logger.debug("Logger successful initialized.")


def extract_orcids(text: str) -> List[str]:
    """Extract ORCID iDs from a given text string.

    ORCID iDs are unique researcher identifiers in the format '0000-0000-0000-000X',
    where 'X' can be a digit or the letter 'X'. This function searches the input
    text for patterns matching the ORCID iD format, including those prefixed with
    'http://', 'https://', or 'orcid.org/'.

    Parameters:
        text (str): The text from which to extract ORCID iDs.

    Returns:
        list of str: A list containing all the ORCID iDs found in the text.

    Example:
        >>> text = "Authors: 0000-0002-1825-0097, https://orcid.org/0000-0001-2345-6789"
        >>> extract_orcids(text)
        ['0000-0002-1825-0097', '0000-0001-2345-6789']
    """
    pattern = r"(?:https?://)?(?:orcid\.org/)?(\d{4}-\d{4}-\d{4}-\d{3}[\dX])"
    matches = re.finditer(pattern, text)
    orcids = [match.group(1) for match in matches]
    return orcids


def extract_emails(text):
    """Extract email addresses from a given text string.

    This function searches the input text for patterns matching standard email address formats.
    It uses a regular expression to identify email addresses, which consist of an email prefix
    and an email domain, both in acceptable formats.

    Parameters:
        text (str): The text from which to extract email addresses.

    Returns:
        list of str: A list containing all the email addresses found in the text.

    Example:
        >>> text = "Contact us at support@example.com or sales@example.co.uk."
        >>> extract_emails(text)
        ['support@example.com', 'sales@example.co.uk']
    """
    # Regular expression pattern for matching email addresses
    pattern = r"[\w\.-]+@[\w\.-]+\.\w+"
    emails = re.findall(pattern, text)
    return emails
