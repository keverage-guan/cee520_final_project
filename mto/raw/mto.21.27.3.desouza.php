 
 

<!-------------------------------- HEADER -------------------------------------------->

    
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="https://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
<head>

<title> MTO 27.3: De Souza, Review of John Paul Ito, Focal Impulse Theory</title>

<link rel="SHORTCUT ICON" href="https://www.mtosmt.org/gifs/favicon.ico">
<link rel="stylesheet" href="https://www.mtosmt.org/scripts/colorbox.css">
<link rel=StyleSheet href="https://www.mtosmt.org/scripts/mto-tufte.css" type="text/css" media=all>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

<script src="https://www.google-analytics.com/urchin.js" type="text/javascript"></script>
<script type="text/javascript">_uacct = "UA-968147-1"; urchinTracker();</script>

<script type="text/javascript" src="https://www.mtosmt.org/scripts/expandingMenu.js"></script>
<script type="text/javascript" src="https://www.mtosmt.org/scripts/dropdownMenu.js"></script>
<!--<script language="JavaScript" type="text/javascript" src="https://www.mtosmt.org/scripts/AC_QuickTime.js"></script>-->
<!--<script type="text/javascript" src="https://www.mtosmt.org/scripts/examples.js"></script>-->
<script type="text/javascript" src="https://www.mtosmt.org/scripts/hover.js"></script>  
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="https://www.mtosmt.org/scripts/colorbox-master/jquery.colorbox.js"></script>
<script type="text/javascript" src="https://www.mtosmt.org/scripts/jQueryRotate.2.2.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.1/MathJax.js?config=TeX-AMS-MML_HTMLorMML'></script>
<script>
MathJax.Hub.Config({
    TeX: { noErrors: { disabled: true } }
});
</script>

  <script>
   $(function () {
      $(document).tooltip({
        position: { my: "center bottom-10", at: "center top", },
    content: function () {
              return $(this).prop('title');
          }
      });
  });
  </script>

  <style>
    .ui-tooltip {
      color: #3a3a3a;
      font: 300 14px/20px "Lato", "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
      max-width: 600px;
      box-shadow: 0 0 7px gray;
    }
    ol.mto-alpha {
        list-style: lower-alpha none outside;
    }
   ol.mto-alpha li {
       margin-bottom: 0.75em;
       margin-left: 2em;
       padding-left: 0.5em;
    }
  </style>

    <script language="Javascript">
        $(document).ready(function() {
            $(".mp3").colorbox({iframe:true, internalWidth:360, width:400, internalHeight:100, rel:'mp3', height:150, opacity:0.1, onComplete: function(e) {
                $('#colorbox').on({
                    mousedown: function(e){
                        if (~$.inArray(e.target, $('input, textarea, button, a, .no_drag', $('#colorbox')))) return;
                        var os = $('#colorbox').offset(),
                            dx = e.pageX-os.left, dy = e.pageY-os.top;
                        $(document).on('mousemove.drag', function(e){
                            $('#colorbox').offset({ top: e.pageY-dy, left: e.pageX-dx } );
                        });
                    },
                    mouseup: function(){ $(document).unbind('mousemove.drag'); }
                });
            }
        });
            $(".youtube").colorbox({iframe:true, innerWidth:640, innerHeight:390, opacity:0.1, rel:'youtube', onComplete: function(e) {
                $('#colorbox').on({
                    mousedown: function(e){
                        if (~$.inArray(e.target, $('input, textarea, button, a, .no_drag', $('#colorbox')))) return;
                        var os = $('#colorbox').offset(),
                            dx = e.pageX-os.left, dy = e.pageY-os.top;
                        $(document).on('mousemove.drag', function(e){
                            $('#colorbox').offset({ top: e.pageY-dy, left: e.pageX-dx } );
                        });
                    },
                    mouseup: function(){ $(document).unbind('mousemove.drag'); }
                });
            }
        });

      $("a[id^=footnote]").each(function(){
        var fnnum = $(this).attr('id').substring(8);
	var foot_me = '#fndiv'+fnnum;
        $("#footnote" + fnnum).attr('title', $(foot_me).html());

        });


        $("a[id^=citation]").each(function(){
         var separatorPos = $(this).attr('id').lastIndexOf('_');
         var linkid = $(this).attr('id');
         var citeref = $(this).attr('id').substring(8,separatorPos);
         var cite_me = '#citediv'+citeref;
         $("#" + linkid).attr('title', $(cite_me).html());

        });
    });

    </script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-968147-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-968147-1');
</script>


<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 

<meta name="citation_title" content="Review of John Paul Ito, <i>Focal Impulse Theory: Musical Expression, Meter, and the Body</i> (Indiana University Press, 2020)">

    <meta name="citation_author" content="Souza, Jonathan De">
      

<meta name="citation_publication_date" content="2021/09/01">
<meta name="citation_journal_title" content="Music Theory Online">
<meta name="citation_volume" content="27">
<meta name="citation_issue" content="3">

</head>

<body>
<div class="bannertop">
	<a id="smt-link" alt="Society for Music Theory" href="https://www.societymusictheory.org">&nbsp;</a>
</div>
		
		<div style = "height:160px; width:900px; background-image: url('../../gifs/banner_blue_grey_900px.png'); background-repeat: no-repeat; background-position: 0px 0px"></div>
		
<!-------------------------------- MENU -------------------------------------------->

  
<div class="dropdown_menu">

<ul class="fullwidth" id="ddm">
    <li><a href="https://www.mtosmt.org/index.php">MTO Home</a>
    </li>
    <li><a href="https://www.mtosmt.org/issues/mto.24.30.4/toc.30.4.html">Current Issue</a>    </li>
    <li><a href="https://www.mtosmt.org/issues/issues.php"
    	onmouseover="mopen('m3')" 
        onmouseout="mclosetime()">Previous Issues</a>
        <div id="m3" 
            onmouseover="mcancelclosetime()" 
            onmouseout="mclosetime()">
	        <a href="https://www.mtosmt.org/docs/index-author.php">By Author</a>
	        <a href="https://www.mtosmt.org/issues/issues.php">By Volume&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
        </div>
	</li>
	
    <li><a href="https://www.mtosmt.org/docs/authors.html.php"
    	onmouseover="mopen('m4')" 
        onmouseout="mclosetime()">For Authors</a>
        <div id="m4" 
            onmouseover="mcancelclosetime()" 
            onmouseout="mclosetime()">
	        <a href="https://www.mtosmt.org/docs/mto-editorial-policy.html">MTO Editorial Policy</a>
	      <a href="https://www.mtosmt.org/docs/mto-style-guidelines.html">MTO Style Guidelines</a>
	      <a href="https://www.mtosmt.org/docs/how-to-submit-an-article-to-mto.html">How to Submit an Article</a>
	      <a href="https://www.mtosmt.org/ojs">Submit Article Online</a>
	      <a href="https://www.mtosmt.org/docs/reviewers.html">Book Review Guidelines</a>
        </div>
	</li>

 <!--   <li><a href="https://www.mtosmt.org/docs/authors.html">Submit</a>
	</li> -->
	
    <li><a href="https://www.mtosmt.org/mto-jobs.php"
    	onmouseover="mopen('m6')" 
        onmouseout="mclosetime()">Jobs</a>
        <div id="m6" 
            onmouseover="mcancelclosetime()" 
            onmouseout="mclosetime()">
	        <a href="https://www.mtosmt.org/mto-jobs.php">Current Job Listings</a>
	        <a href="https://www.mtosmt.org/mto-job-post.php">Submit Job Listing</a>
        </div>
	</li>
    <li><a href="https://www.mtosmt.org/docs/diss-index.php"
    	onmouseover="mopen('m7')" 
        onmouseout="mclosetime()">Dissertations</a>
        <div id="m7" 
            onmouseover="mcancelclosetime()" 
            onmouseout="mclosetime()">
	        <a href="https://www.mtosmt.org/docs/diss-index.php">All Dissertations</a>
	        <a href="https://www.mtosmt.org/docs/diss-index.php?new=true">New Dissertations</a>
	        <a href="https://www.mtosmt.org/mto-diss-post.php">List Your Dissertation</a>
        </div>
	</li>
    <li><a href="https://www.mtosmt.org/about.html">About</a>
	</li>
<!--    <li><a href="https://www.mtosmt.org/mto_links.html">Journals</a>  
	</li> -->
    <li><a href="https://societymusictheory.org">SMT</a>
	</li>
   <!-- <li><a href="https://societymusictheory.org/announcement/contest-new-mto-logo-2024-02"><span style="color:yellow">Logo Design Contest</span></a>
	</li>-->

</ul>

</div>


<!-------------------------------- TITLE -------------------------------------------->

  <article>

<div id="content">
<a name="Beginning"></a>


	<h1 style="width:900px; margin-top:1em; font-size: 2.4rem;">Review of John Paul Ito, <i>Focal Impulse Theory: Musical Expression, Meter, and the Body</i> (Indiana University Press, 2020)

	</h1>
	<div style="width:900px">
				</div>
				<h2><span style="font-weight: 400"><font size="5"><a style="color:black" href="#AUTHORNOTE1">Jonathan De Souza</a></font></span></h2><br><br><p><font size='4'>KEYWORDS: meter, performance analysis, embodiment, music cognition</font></p>			
	<div style='width:800px'><div style='float:right; font-size:1.2rem;'><a href="https://mtosmt.org/issues/mto.21.27.3/mto.21.27.3.desouza.pdf">PDF text </a> | <a href="https://mtosmt.org/issues/mto.21.27.3/desouza_examples.pdf">PDF examples </a></div></div><div style='width:800px'><div style='float:right; font-size:1.2rem;'></div></div><div style='width:800px'><div style='float:right; font-size:1.2rem;'></div></div><div style='width:800px'><div style='float:right; font-size:1.2rem;'></div></div><div style='width:800px'><div style='float:right; font-size:1.2rem;'></div></div><div style='width:800px'><div style='float:right; font-size:1.2rem;'></div></div><div style='width:800px'><div style='float:right; font-size:1.2rem;'></div></div><div style='width:800px'><div style='float:right; font-size:1.2rem;'></div></div><div style='width:800px'><div style='float:right; font-size:1.2rem;'></div></div><div style='width:800px'><div style='float:right; font-size:1.2rem;'></div></div><div style='width:800px'><div style='float:right; font-size:1.2rem;'></div></div><div style='width:800px'><div style='float:right; font-size:1.2rem;'></div></div>
			<div style="float:left; font-size:1.1rem;"><i>Received May 2021</i></div>
		<div style="width:850px">
	<div style="text-align:center; font-size: 1.1rem; margin-bottom:2em;margin-top:4em;margin-right:auto;margin-left:auto;width:870px">
		Volume 27, Number 3, September 2021 <br> Copyright &#0169; 2021 Society for Music Theory	</div>
	</div>

<hr style="width:850px"><br>
<section>
<!-------------------------------- ARTICLE BODY (begin) -------------------------------------->

<fig>
 <p class='fullwidth' style="text-align: center; margin-top:0em"><b>Example 1</b>. Bach, Partita No. 3 for Solo Violin, BWV 1006, Loure, mm. 1&ndash;2</p><p class='fullwidth' style="text-align: center; margin-bottom:0em"><a class='youtube'  target="blank" href="desouza_examples.php?id=0&nonav=true"><img border="1" alt="Example 1 thumbnail" src="desouza_ex1_small.png"></a></p><p class='fullwidth' style="text-align: center; margin-top:0em"><font size="2">(click to enlarge)</font></p>  <p class='fullwidth' style="text-align: center; margin-top:0em; margin-bottom:0.5em"><b>Audio Example 1</b>. Bach&rsquo;s Loure for solo violin, performed by Jascha Heifetz (1952)</p><p class='fullwidth' style="text-align: center; margin-top:0em;"><audio preload="metadata" controls style="width:300px"><source src="desouza_audioex1.mp3" type="audio/mpeg"><source src="desouza_audioex1.ogg" type="audio/ogg"><script language="JavaScript" type="text/javascript"></script></audio></p>  <p class='fullwidth' style="text-align: center; margin-top:0em; margin-bottom:0.5em"><b>Audio Example 2</b>. Bach&rsquo;s Loure for solo violin, performed by Sergiu Luca (1977)</p><p class='fullwidth' style="text-align: center; margin-top:0em;"><audio preload="metadata" controls style="width:300px"><source src="desouza_audioex2.mp3" type="audio/mpeg"><source src="desouza_audioex2.ogg" type="audio/ogg"><script language="JavaScript" type="text/javascript"></script></audio></p>
</fig>

<p>[1] <b>Example 1</b> presents the beginning of the Loure from Johann Sebastian Bach&rsquo;s Partita No. 3 for Solo Violin. With this movement, there seem to be two main performance traditions. Jascha Heifetz (<a href="#heifetz_1952" id="citation_heifetz_1952_67dc995639eac">1952</a>, <b>Audio Example 1</b>) represents one approach, along with Itzhak Perlman (<a href="#perlman_1988" id="citation_perlman_1988_67dc995639eb2">1988</a>), Hilary Hahn (<a href="#hahn_1997" id="citation_hahn_1997_67dc995639eb6">1997</a>), and Midori (<a href="#midori_2015" id="citation_midori_2015_67dc995639eba">2015</a>). Sergiu Luca (<a href="#luca_1977" id="citation_luca_1977_67dc995639ebd">1977</a>, <b>Audio Example 2</b>) represents another, along with Suyoen Kim (<a href="#kim_2011" id="citation_kim_2011_67dc995639ec0">2011</a>) and Gil Shaham (<a href="#shaham_2015" id="citation_shaham_2015_67dc995639ec3">2015</a>). How can we compare these interpretations? We might start from individual musical elements: Heifetz&rsquo;s articulation is more legato, Luca&rsquo;s tempo is slightly faster, and so forth. Alternatively, we might consider the overall character of these performances. As I hear it, Heifetz&rsquo;s is more stately, while Luca&rsquo;s is more dance-like, in keeping with descriptions of the loure as a slow gigue (<a href="#little_2001" id="citation_little_2001_67dc995639ec7">Little 2001</a>). Similarly, one YouTube viewer appreciates Hahn&rsquo;s interpretation for its &ldquo;tenderness,&rdquo; though Shaham&rsquo;s is &ldquo;maybe more FUN&rdquo; (<a href="#simiamens_nd" id="citation_simiamens_nd_67dc995639ecc">simiamens n.d.</a>). But how can we connect the performances&rsquo; musical details to these expressive qualities? John Paul Ito&rsquo;s new book offers a principled way to integrate these levels, based on performers&rsquo; bodily movement. For Ito, these interpretive traditions differ in their placement of <i>focal impulses</i>.</p>

<p>[2] What is a focal impulse? It is a kind of motion, produced by a performer&rsquo;s body (271). &ldquo;An <i>impulse</i>,&rdquo; Ito explains, &ldquo;is a muscular contraction with a clearly observable moment of initiation&rdquo; (56). A <i>focal</i> impulse (as opposed to a <I>subsidiary</i> impulse) launches a musical gesture that continues throughout some <i>consequent span</i>. This impulse might create a sound, but it also creates a context for events that follow. Various physical analogies help to clarify the concept: skipping a stone, hitting a racquetball that ricochets around the court, or, in skateboarding, pushing off the surface of the half pipe to set up an aerial trick (63&ndash;64). In each case, a focal impulse injects energy into a dynamic system of motion and shapes its possibilities. The book&rsquo;s central claim, then, is that &ldquo;motion in performance is organized around and segmented by the focal impulses, with the performer playing or singing from focal impulse to focal impulse&rdquo; (57)&mdash;or, more succinctly, that &ldquo;some motions play a special role in organizing other motions&rdquo; (336).</p>

<fig>
 <p class='fullwidth' style="text-align: center; margin-top:0em"><b>Example 2</b>. Focal impulse placement in two performances of Bach&rsquo;s Loure for solo violin (78, Example 4.3)</p><p class='fullwidth' style="text-align: center; margin-bottom:0em"><a class='youtube'  target="blank" href="desouza_examples.php?id=1&nonav=true"><img border="1" alt="Example 2 thumbnail" src="desouza_ex2_small.png"></a></p><p class='fullwidth' style="text-align: center; margin-top:0em"><font size="2">(click to enlarge)</font></p></fig>

<p>[3] In the Loure, Heifetz&rsquo;s focal impulses form an uneven long-short pattern, while Luca places them only on strong beats (77&ndash;78). <b>Example 2</b> reproduces Ito&rsquo;s analysis of their performances. In the example, focal impulses are indicated above the staff: these symbols combine a vertical line, which shows the moment of initiation, with an open-ended slur, which indicates the consequent span. Slower tempos generally require more focal impulses per measure to maintain energy (65), and this helps to account for the rate of focal impulses in Heifetz&rsquo;s performance. Notes that coincide with focal impulses are often accented through louder dynamics, distinctive articulation (92), or subtle agogic accents that give slightly more time at or just before the focal impulse (87). This is particularly audible in the Loure&rsquo;s opening anacrusis. For Heifetz, the quarter-note B5 is weighty, sustained with both bow and vibrato. Luca, by contrast, lets go of the note almost immediately, leaving a brief space before the focal impulse on the downbeat. Focal impulse placement, then, brings together differences involving bodily motion, timing, and expression&mdash;effectively, the three elements in the book&rsquo;s subtitle.</p>

<p>[4] How do these elements relate? Ito states that &ldquo;focal impulse theory is, first and foremost, a theory about the body&rdquo; (334), suggesting that performing bodies ground both musical timing and expression. Focal impulses interact with meter in subtle ways. They often coincide with strong positions in the metrical grid, but as Heifetz&rsquo;s long-short pattern shows, they do not always reproduce a particular metrical level or an isochronous sequence of beats. At the same time, focal impulses are expressive. Bodily movements, in this view, do not simply transmit preexistent musical meanings, which would originate in the mind; instead, bodies are an essential source of musical meaning.</p>

<p>[5] This trio of concepts&mdash;body, meter, and expression&mdash;invites the engagement of a wide readership. Obviously, it will interest music theorists who work on these topics. Ito&rsquo;s accessible and insightful prose may also inspire performers and music psychologists, especially those who study timing and motor control. Ito&rsquo;s pedagogical strategy is effective in reaching this wide readership: his book first cultivates <i>experiences</i> of focal impulses&mdash;through musical examples, bodily exercises, analogies, and thought experiments&mdash;before presenting theoretical terms and symbols. The book&rsquo;s sound and video examples, in which Ito and numerous collaborators demonstrate varied focal impulses, were particularly helpful.<sup><a name="FN1REF" href="#FN1" id="footnote1">(1)</a></sup> They show Ito in a double role as a theorist and a violist&mdash;that is, as a scholar who analyzes scores and recordings, and a practitioner who seeks satisfying creative possibilities. Focal impulse theory, then, supports analysis <i>of</i> and <i>for</i> performance. Throughout his book, Ito aims to be evaluative but not prescriptive. He hopes to enliven performance, listening, and analysis by developing a &ldquo;new conceptual framework for an old, familiar experience&rdquo; (343).</p>

<p>[6] The book is organized in five parts. Chapter 1 introduces focal impulses through familiar experiences, such as feeling the music in two or in four. Key examples here involve focal impulses on strong-beat rests. The notes that follow a silent focal impulse have a distinctive rhythmic character, which changes if the rest is replaced by a note. Moreover, Ito claims that musicians often move on the rest in a way that facilitates the subsequent attack. &ldquo;If we viewed performance as the stringing together of isolated motions,&rdquo; Ito observes, &ldquo;there would be no need to move on these rests&mdash;after all, when rests do not fall on strong beats, they do not usually inspire motion of this sort&rdquo; (7). To make the book more accessible to performers and students without extensive theory training (23), Chapter 2 reviews some relevant concepts from music theory and cognitive science: Lerdahl and Jackendoff&rsquo;s (<a href="#lerdahl_and_jackendoff_1983" id="citation_lerdahl_and_jackendoff_1983_67dc995639efa">1983</a>) distinction between meter and grouping, metrical grids, prototype categories, syncopation, metrical dissonance, and hypermeter. Even readers who are already well acquainted with this material will benefit from Ito&rsquo;s concise and effective presentation, which includes many apt musical illustrations.</p>

<fig>
 <p class='fullwidth' style="text-align: center; margin-top:0em"><b>Example 3</b>. Ito&rsquo;s recompositions of a theme from Beethoven&rsquo;s Overture to <i>The Creatures of Prometheus</i>, op. 43 (62, Example 3.5)</p><p class='fullwidth' style="text-align: center; margin-bottom:0em"><a class='youtube'  target="blank" href="desouza_examples.php?id=2&nonav=true"><img border="1" alt="Example 3 thumbnail" src="desouza_ex3_small.png"></a></p><p class='fullwidth' style="text-align: center; margin-top:0em"><font size="2">(click to enlarge and see the rest)</font></p></fig>

<p>[7] Part 2 lays out the basics of focal impulse theory. Though Chapter 3 provides &ldquo;an abstract, general definition&rdquo; (55), its central goal is again to make the definition experientially relevant, through examples, exercises, and analogies. One strategy for finding focal impulses involves removing notes, a kind of reduction analysis for investigating rhythm and performance: &ldquo;If all of the notes except those produced by the focal impulses are stripped away, playing the result reveals a simple sequence of motion; the motion needed to play the actual passage is an elaboration of this simple sequence&rdquo; (62&ndash;63). <b>Example 3</b> presents Ito&rsquo;s reductive recompositions of a passage from Ludwig van Beethoven&rsquo;s Overture to <i>The Creatures of Prometheus</i>, op. 43. The original melody involves a constant stream of eighth notes, but Ito filters out notes according to a consistent rhythmic pattern (e.g., Example 3a omits the final eighth note from each four-note group, and Example 3b omits the second eighth note from each group). Examples 3a to 3c eliminate notes that do not correspond to focal impulses, as a means of uncovering this &ldquo;simple sequence of motion.&rdquo; By contrast, Example 3d removes notes on the downbeats that are produced by focal impulses. Here the character of the melody changes more substantially, and when performing the passage, Ito feels compelled to move on these active rests. Chapter 5 further examines focal impulses&rsquo; sonic traces, which can be detected in the domains of tempo, articulation, microtiming, and dynamics. As Ito notes, often it is hard to disentangle the contributions of these individual musical elements, yet the overall gestalt of each focal impulse pattern is clear. In other cases, he admits that the sonic cues are too ambiguous to determine a particular focal impulse pattern (86). Despite these challenges, his holistic approach in these chapters&mdash;combining close listening, visual attention to performers&rsquo; motion, and kinesthetic exercises&mdash;makes focal impulses perceptible.</p>

<p>[8] Chapters 4 and 6 consider the relation between focal impulses and meter. Usually, focal impulses align with some level of the metrical grid and appear at least on each downbeat. This placement tends to be consistent throughout a passage that has a consistent type of motion. Ito&rsquo;s theory is based on meter rather than grouping because the former is more regular and hence supports more efficient motor organization. Moreover, focal impulses show how &ldquo;leaning on and pushing off from things that are stable and predictable makes possible the freedom, variety, and shape of rhythmic performance; without a skeleton to pull against, muscles can be nothing but twitching blobs&rdquo; (252). But he also considers differences between meter and focal impulses: where Lerdahl and Jackendoff&rsquo;s metrical hierarchy is abstract and deep, Ito&rsquo;s impulse hierarchy is physical and relatively shallow, with no more than three levels (195). Though they do interact, focal impulses and metrical processes are distinct.</p>

<fig>
 <p class='fullwidth' style="text-align: center; margin-top:0em"><b>Example 4</b>. Three types of syncopation, distinguished by their relation to focal impulses (113, Example 7.1)</p><p class='fullwidth' style="text-align: center; margin-bottom:0em"><a class='youtube'  target="blank" href="desouza_examples.php?id=3&nonav=true"><img border="1" alt="Example 4 thumbnail" src="desouza_ex4_small.png"></a></p><p class='fullwidth' style="text-align: center; margin-top:0em"><font size="2">(click to enlarge)</font></p></fig>

<p>[9] Chapter 7 asks how syncopated notes push off from focal impulses. Ito proposes three types of syncopation, which are illustrated in <b>Example 4</b>. With <i>vigorous syncopation</i>, focal impulses and syncopated notes are misaligned but they move at the same rate. In this prototypical kind of syncopation, each focal impulse produces only one note. With <i>grounded syncopation</i>, the rate of syncopation is slower than the focal impulses. The syncopated notes align with focal impulses, so they typically feel more restful, heavy, and sustained. Finally, with <i>floating syncopation</i>, the syncopated notes are more rapid than the focal impulses. As their descriptive names show, the three types involve particular impulse patterns but also distinct characters.</p>

<fig>
 <p class='fullwidth' style="text-align: center; margin-top:0em"><b>Example 5</b>. Categories of qualitatively inflected focal impulse (172, Table 10.1)</p><p class='fullwidth' style="text-align: center; margin-bottom:0em"><a class='youtube'  target="blank" href="desouza_examples.php?id=4&nonav=true"><img border="1" alt="Example 5 thumbnail" src="desouza_ex5_small.png"></a></p><p class='fullwidth' style="text-align: center; margin-top:0em"><font size="2">(click to enlarge)</font></p></fig>

<p>[10] More advanced aspects of Ito&rsquo;s theory are discussed in Part 3. This section addresses non-prototypical focal impulse patterns, such as those involving asymmetrical meters, conflicts between notated and heard meter, hemiolas, anticipations, and the <i>impulse polyphony</i> that emerges when &ldquo;members of an ensemble place focal impulses differently&rdquo; (129). Chapter 9 also introduces <i>secondary focal impulses</i>, which organize lower-level subsidiary impulses but are simultaneously organized by a higher-level primary focal impulse. Yet some of this part&rsquo;s deepest insights result not from these exceptional cases but from revisiting and deepening the basic principles from Part 2. For example, Chapters 10 and 11 describe qualitative differences between focal impulses. Ito guides readers through a series of physical exercises that involve conducting in two and conducting in one, closely attending to movement, muscular tension, weight, and gravity. This analysis of bodily experience sets up two theoretical oppositions: between downward (tension-releasing) and upward (tension-gathering) focal impulses, and between focal impulses that do not bounce back and those that do (cyclical impulses). Combined, these two oppositions create four focal impulse qualities, represented by arrows in Ito&rsquo;s Table 10.1 (172, reproduced here as <b>Example 5</b>). As Ito emphasizes, &ldquo;Focal impulses that gather tension and focal impulses that release tension are hierarchically equivalent: neither governs the other or provides a motional context for the other&rsquo;s consequent span&rdquo; (167). </p>

<fig>
 <p class='fullwidth' style="text-align: center; margin-top:0em"><b>Example 6</b>. Focal impulse quality in two performances of Bach&rsquo;s Loure for solo violin</p><p class='fullwidth' style="text-align: center; margin-bottom:0em"><a class='youtube'  target="blank" href="desouza_examples.php?id=5&nonav=true"><img border="1" alt="Example 6 thumbnail" src="desouza_ex6_small.png"></a></p><p class='fullwidth' style="text-align: center; margin-top:0em"><font size="2">(click to enlarge)</font></p></fig>


<p>[11] Let me illustrate these qualitative differences by building on Ito&rsquo;s analysis of Bach&rsquo;s Loure. Heifetz&rsquo;s long-short pattern involves an <i>impulse cycle</i>. On the strong beats, <i>downward focal impulses</i> release tension, alternating with <i>upward focal impulses</i> that gather tension (172). To feel this distinction, conduct the long-short pattern indicated in <b>Example 6b</b> with a down-up motion, paying attention to the increase in muscular tension as the upstroke resists gravity (in Ito&rsquo;s image, this is like pulling a bungee cord). The gathering tension of the upward focal impulses, combined with the relatively slow tempo, grounds the deliberate character of Heifetz&rsquo;s performance. Meanwhile, Luca&rsquo;s performance involves cyclical focal impulses, which correspond to the standard pattern for conducting in one (see <b>Example 6a</b>). They release tension but bounce back to a state of readiness, so Luca&rsquo;s performance feels light and springy. Of course, these are not the only possibilities here, and Ito considers less-common options in the Loure (201, Video 11.2). Still, these inflected focal impulses help to explain why Heifetz&rsquo;s performance recalls a noble procession, while Luca&rsquo;s suggests joyous leaps. They imply particular kinds of movement or, in Lawrence Zbikowski&rsquo;s (<a href="#zbikowski_2017" id="citation_zbikowski_2017_67dc995639f2b">2017</a>) terms, sonic analogues for dynamic processes.</p>


<p>[12] Part 4 connects the book to other scholarship. Chapter 13 considers its relation to psychology, including music psychology, speech psychology, and motor psychology. A brief history of motor control research in Section 13.4 has fascinating implications for musical practice (e.g., changing tempo also affects movement, so slow practice and fast performance involve different physical actions). Ito believes that some aspects of his theory are empirically testable, and he alludes to relevant experiments in progress. He considers other aspects to be an &ldquo;extended metaphor&rdquo; that might have explanatory value as a model, even if it is not literally true. Chapter 14 considers earlier work on music and embodiment, including practically oriented thinkers such as &Eacute;mile Jacques-Dalcroze (<a href="#jacques-dalcoze_1916" id="citation_jacques-dalcoze_1916_67dc995639f2f">1916</a>) and Alexandra Pierce (<a href="#pierce_2007" id="citation_pierce_2007_67dc995639f33">2007</a>). Ito notes that focal impulse theory is consonant with Arnie Cox&rsquo;s (<a href="#cox_2016" id="citation_cox_2016_67dc995639f36">2016</a>) mimetic hypothesis, according to which listeners overtly or covertly mirror performer&rsquo;s actions. In certain respects, focal impulse theory also resembles Christopher Hasty&rsquo;s (<a href="#hasty_1997" id="citation_hasty_1997_67dc995639f39">1997</a>) theory of metrical projection: both emphasize beginnings and treat meter as an active process (270&ndash;71). Nonetheless, Ito suggests that projection is more mental and listener-centered, while focal impulses are physical and performative, and he believes that the two theories &ldquo;are simply talking about different things&rdquo; (271). This wide-ranging discussion continues in the book&rsquo;s conclusion.</p>

<p>[13] Part 5 applies focal impulse theory to compositions by Johannes Brahms. Ito showcases the process of developing an analytical or performative interpretation, including false starts and unsatisfying options, trade-offs and personal preferences. While Chapter 15 consolidates the preceding material, it also previews an unpublished corpus study of metrical dissonance in Brahms&rsquo;s music, sharing selected results (without all of the methodological details that will presumably appear in future publications). Chapter 16 presents analyses of the first movements from Brahms&rsquo;s op. 120 sonatas for clarinet and piano. The book&rsquo;s supplementary materials include complete performances, by the author (on viola) and the pianist/theorist David Keep. A full annotated score is also available online, making it easy to conduct along with their interpretation.<sup><a name="FN2REF" href="#FN2" id="footnote2">(2)</a></sup> The dark, restless first movement of the F-minor sonata contrasts with the lush calm of the E-flat-major sonata. Yet they develop and resolve similar metrical conflicts: in both, meter and hypermeter are relatively stable in the first theme, but as the exposition progresses, metrical dissonance and hypermetric irregularity increase. Here Ito offers insight into challenging moments for analysis and performance, while also clarifying metrical and rhythmic aspects of large-scale form and musical narrative.</p>

<p>[14] The book&rsquo;s conclusion considers dance, ethnomusicological studies of rhythm in music from West Africa, Bali, and Iran, and meter in Western popular music. Ito briefly analyzes focal impulses in three versions of &ldquo;Stop in the Name of Love,&rdquo; performed by the Supremes, Jonell Mosser, and the Sons of Serendip. These topics are a departure from the book&rsquo;s main focus on the Western art music canon from Bach to Brahms, and, while Ito is confident in his analysis of Western popular music, he is uncertain about which aspects of the theory might generalize to repertories from other cultures. On the one hand, the theory addresses basic aspects of movement and timing; on the other, focal impulse theory emerges from a historically specific performance practice, and it is not yet clear how relevant it is to musical practices such as Malian drumming (340). Like experimental testing, cross-cultural research would help to clarify the possibilities and limits of the theory.</p>

<p>[15] <i>Focal Impulse Theory</i> centers temporality in musical embodiment (337), a goal it shares with books such as David Burrows&rsquo;s <i>Time and the Warm Body</i> (<a href="#burrows_2007" id="citation_burrows_2007_67dc995639f56">2007</a>) and Mariusz Kozak&rsquo;s <i>Enacting Musical Time</i> (<a href="#kozak_2019" id="citation_kozak_2019_67dc995639f59">2019</a>). While it is less philosophical than those texts and does not draw on phenomenological literature, Ito&rsquo;s contribution is still phenomenological in a general sense (269). That is, his theory is founded on lived experience while also aiming to enrich it. He attends to musical phenomena that are familiar and often taken for granted. Like the phenomenological analysis of everyday life, this work helps us &ldquo;to rediscover the world in which we live, yet which we are always prone to forget&rdquo; (<a href="#merleau-ponty_2008" id="citation_merleau-ponty_2008_67dc995639f5c">Merleau-Ponty 2008</a>, 32). For music theorists, performers, and students alike, this remarkable book will open up new ways of feeling and thinking about meter, expression, and embodied performance.</p>

<!-------------------------------- END Article Body -------------------------------------------->

     
	<div style="height:24px;width:150px;background-color:#4c7381;float:left;text-align: center;vertical-align: middle;line-height: 24px;">
		&nbsp;&nbsp;&nbsp;
		<a style="color:white;" onmouseover="this.style.color='#0000ff';text-decoration:none" 
		onmouseout="this.style.color='white';" href="#Beginning">Return to beginning</a>
		&nbsp;&nbsp;&nbsp;
	</div><br><br>

	
<!-------------------------------- Author Info -------------------------------------------->

  
<hr>

	<p><a name="AUTHORNOTE1"></a>
	
	Jonathan De Souza<br>
	Western University<br>Don Wright Faculty of Music<br>Talbot College<br>London, ON N6A 3K7<br>Canada<br><a href="mailto:jdesou22@uwo.ca">jdesou22@uwo.ca</a><br>	
</p>

       
	<div style="height:24px;width:150px;background-color:#4c7381;float:left;text-align: center;vertical-align: middle;line-height: 24px;">
		&nbsp;&nbsp;&nbsp;
		<a style="color:white;" onmouseover="this.style.color='#0000ff';text-decoration:none" 
		onmouseout="this.style.color='white';" href="#Beginning">Return to beginning</a>
		&nbsp;&nbsp;&nbsp;
	</div><br><br>

	
<!-------------------------------- Works Cited List -------------------------------------------->

  
	<hr>
	
	<h3><a name="WorksCited">Works Cited</a></h3>
	
	<div id="citediv_burrows_2007" class="flyoverdiv">Burrows, David L. 2007. <i>Time and the Warm Body: A Musical Perspective on the Construction of Time</i>. Brill.</div><p style="text-indent: -1em; margin-left: 1em; margin-top: 0em"><a name="burrows_2007"></a>Burrows, David L. 2007. <i>Time and the Warm Body: A Musical Perspective on the Construction of Time</i>. Brill.</p><div id="citediv_cox_2016" class="flyoverdiv">Cox, Arnie. 2016. <i>Music and Embodied Cognition: Listening, Moving, Feeling, and Thinking</i>. Indiana University Press.</div><p style="text-indent: -1em; margin-left: 1em; margin-top: 0em"><a name="cox_2016"></a>Cox, Arnie. 2016. <i>Music and Embodied Cognition: Listening, Moving, Feeling, and Thinking</i>. Indiana University Press.</p><div id="citediv_hasty_1997" class="flyoverdiv">Hasty, Christopher. 1997. <i>Meter as Rhythm</i>. Oxford University Press.</div><p style="text-indent: -1em; margin-left: 1em; margin-top: 0em"><a name="hasty_1997"></a>Hasty, Christopher. 1997. <i>Meter as Rhythm</i>. Oxford University Press.</p><div id="citediv_ito_2020" class="flyoverdiv">Ito, John Paul. 2020. <i>Focal Impulse Theory: Musical Expression, Meter, and the Body</i>. Indiana University Press.</div><p style="text-indent: -1em; margin-left: 1em; margin-top: 0em"><a name="ito_2020"></a>Ito, John Paul. 2020. <i>Focal Impulse Theory: Musical Expression, Meter, and the Body</i>. Indiana University Press.</p><div id="citediv_jacques-dalcoze_1916" class="flyoverdiv">Jacques-Dalcroze, &Eacute;mile. 1916. <i>La rythmique: Enseignment pour le d&eacute;veloppement de l&rsquo;instinct rythmique et m&eacute;trique, du sens de l&rsquo;harmonie plastique et de l&rsquo;equilibre des mouvements, et pour la r&eacute;gularisation des habitudes motrices</i>. Vol. 1. Jobin.</div><p style="text-indent: -1em; margin-left: 1em; margin-top: 0em"><a name="jacques-dalcoze_1916"></a>Jacques-Dalcroze, &Eacute;mile. 1916. <i>La rythmique: Enseignment pour le d&eacute;veloppement de l&rsquo;instinct rythmique et m&eacute;trique, du sens de l&rsquo;harmonie plastique et de l&rsquo;equilibre des mouvements, et pour la r&eacute;gularisation des habitudes motrices</i>. Vol. 1. Jobin.</p><div id="citediv_kozak_2019" class="flyoverdiv">Kozak, Mariusz. 2019. <i>Enacting Musical Time: The Bodily Experience of New Music</i>. Oxford University Press.</div><p style="text-indent: -1em; margin-left: 1em; margin-top: 0em"><a name="kozak_2019"></a>Kozak, Mariusz. 2019. <i>Enacting Musical Time: The Bodily Experience of New Music</i>. Oxford University Press.</p><div id="citediv_lerdahl_and_jackendoff_1983" class="flyoverdiv">Lerdahl, Fred, and Ray Jackendoff. 1983. <i>A Generative Theory of Tonal Music</i>. MIT Press.</div><p style="text-indent: -1em; margin-left: 1em; margin-top: 0em"><a name="lerdahl_and_jackendoff_1983"></a>Lerdahl, Fred, and Ray Jackendoff. 1983. <i>A Generative Theory of Tonal Music</i>. MIT Press.</p><div id="citediv_little_2001" class="flyoverdiv">Little, Meredith Ellis. 2001. &ldquo;Loure.&rdquo; <i>Grove Music Online</i>. <a href='https://doi.org/10.1093/gmo/9781561592630.article.17043'>https://doi.org/10.1093/gmo/9781561592630.article.17043</a></div><p style="text-indent: -1em; margin-left: 1em; margin-top: 0em"><a name="little_2001"></a>Little, Meredith Ellis. 2001. &ldquo;Loure.&rdquo; <i>Grove Music Online</i>. <a href='https://doi.org/10.1093/gmo/9781561592630.article.17043'>https://doi.org/10.1093/gmo/9781561592630.article.17043</a></p><div id="citediv_merleau-ponty_2008" class="flyoverdiv">Merleau-Ponty, Maurice. 2008. <i>The World of Perception</i>. First edition. Translated by Oliver Davis. Routledge.</div><p style="text-indent: -1em; margin-left: 1em; margin-top: 0em"><a name="merleau-ponty_2008"></a>Merleau-Ponty, Maurice. 2008. <i>The World of Perception</i>. First edition. Translated by Oliver Davis. Routledge.</p><div id="citediv_simiamens_nd" class="flyoverdiv">Simiamens. n.d. Comment on Grandesmusicos, &ldquo;Gil Shaham - Partita N&deg;. 3 BWV 1006 - Loure.&rdquo; YouTube video, May 19, 2011. <a href='https://youtu.be/_smG-o1lVMc'>https://youtu.be/_smG-o1lVMc</a></div><p style="text-indent: -1em; margin-left: 1em; margin-top: 0em"><a name="simiamens_nd"></a>Simiamens. n.d. Comment on Grandesmusicos, &ldquo;Gil Shaham - Partita N&deg;. 3 BWV 1006 - Loure.&rdquo; YouTube video, May 19, 2011. <a href='https://youtu.be/_smG-o1lVMc'>https://youtu.be/_smG-o1lVMc</a></p><div id="citediv_pierce_2007" class="flyoverdiv">Pierce, Alexandra. 2007. <i>Deepening Musical Performance through Movement: The Theory and Practice of Embodied Interpretation</i>. Indiana University Press.</div><p style="text-indent: -1em; margin-left: 1em; margin-top: 0em"><a name="pierce_2007"></a>Pierce, Alexandra. 2007. <i>Deepening Musical Performance through Movement: The Theory and Practice of Embodied Interpretation</i>. Indiana University Press.</p><div id="citediv_zbikowski_2017" class="flyoverdiv">Zbikowski, Lawrence M. 2017. <i>Foundations of Musical Grammar</i>. Oxford University Press.</div><p style="text-indent: -1em; margin-left: 1em; margin-top: 0em"><a name="zbikowski_2017"></a>Zbikowski, Lawrence M. 2017. <i>Foundations of Musical Grammar</i>. Oxford University Press.</p><div id="citediv_hahn_1997" class="flyoverdiv">Hahn, Hilary. 1997. <i>Hilary Hahn Plays Bach</i>. Sony Classical SK 62793.</div><p style="text-indent: -1em; margin-left: 1em; margin-top: 0em"><a name="hahn_1997"></a>Hahn, Hilary. 1997. <i>Hilary Hahn Plays Bach</i>. Sony Classical SK 62793.</p><div id="citediv_heifetz_1952" class="flyoverdiv">Heifetz, Jascha. 1952. <i>J. S. Bach: Sonatas and Partitas for Unaccompanied Violin</i>. RCA Victor 7708-2-RG.</div><p style="text-indent: -1em; margin-left: 1em; margin-top: 0em"><a name="heifetz_1952"></a>Heifetz, Jascha. 1952. <i>J. S. Bach: Sonatas and Partitas for Unaccompanied Violin</i>. RCA Victor 7708-2-RG.</p><div id="citediv_kim_2011" class="flyoverdiv">Kim, Suyoen. 2011. <i>J. S. Bach: Sonatas and Partitas</i>. Universal Music (Korea).</div><p style="text-indent: -1em; margin-left: 1em; margin-top: 0em"><a name="kim_2011"></a>Kim, Suyoen. 2011. <i>J. S. Bach: Sonatas and Partitas</i>. Universal Music (Korea).</p><div id="citediv_luca_1977" class="flyoverdiv">Luca, Sergiu. 1977. <i>Johann Sebastian Bach: The Sonatas and Partitas for Unaccompanied Violin</i>. Elektra Nonesuch 9 73030-2.</div><p style="text-indent: -1em; margin-left: 1em; margin-top: 0em"><a name="luca_1977"></a>Luca, Sergiu. 1977. <i>Johann Sebastian Bach: The Sonatas and Partitas for Unaccompanied Violin</i>. Elektra Nonesuch 9 73030-2.</p><div id="citediv_midori_2015" class="flyoverdiv">Midori. 2015. <i>Bach: Sonatas and Partitas for Solo Violin</i>. Onyx Classics ONYX 4123.</div><p style="text-indent: -1em; margin-left: 1em; margin-top: 0em"><a name="midori_2015"></a>Midori. 2015. <i>Bach: Sonatas and Partitas for Solo Violin</i>. Onyx Classics ONYX 4123.</p><div id="citediv_perlman_1988" class="flyoverdiv">Perlman, Itzhak. 1988. <i>Sonaten und Partiten</i>. EMI CDS 7 49483 2.</div><p style="text-indent: -1em; margin-left: 1em; margin-top: 0em"><a name="perlman_1988"></a>Perlman, Itzhak. 1988. <i>Sonaten und Partiten</i>. EMI CDS 7 49483 2.</p><div id="citediv_shaham_2015" class="flyoverdiv">Shaham, Gil. 2015. <i>J. S. Bach: Sonatas and Partitas for Violin</i>. Canary Classics CC14.</div><p style="text-indent: -1em; margin-left: 1em; margin-top: 0em"><a name="shaham_2015"></a>Shaham, Gil. 2015. <i>J. S. Bach: Sonatas and Partitas for Violin</i>. Canary Classics CC14.</p>
     
	<div style="height:24px;width:150px;background-color:#4c7381;float:left;text-align: center;vertical-align: middle;line-height: 24px;">
		&nbsp;&nbsp;&nbsp;
		<a style="color:white;" onmouseover="this.style.color='#0000ff';text-decoration:none" 
		onmouseout="this.style.color='white';" href="#Beginning">Return to beginning</a>
		&nbsp;&nbsp;&nbsp;
	</div><br><br>

	
<!-------------------------------- Footnotes List -------------------------------------------->

  	
	<hr>
	
	<h3><a name="Footnotes">Footnotes</a></h3>
	
	<p><a name="FN1">1.</a> Supplementary sound and video examples are available online at https://media.dlib.indiana.edu/media_objects/765376507. <br><a href="#FN1REF">Return to text</a></p><p><a name="FN2">2.</a> Annotated scores are hosted on their own webpage: https://kilthub.cmu.edu/articles/media/Focal_Impulse_Theory_Supplemental_Online_Scores/13150388.<br><a href="#FN2REF">Return to text</a></p><div id="fndiv1" class="flyoverdiv">Supplementary sound and video examples are available online at https://media.dlib.indiana.edu/media_objects/765376507. </div><div id="fndiv2" class="flyoverdiv">Annotated scores are hosted on their own webpage: https://kilthub.cmu.edu/articles/media/Focal_Impulse_Theory_Supplemental_Online_Scores/13150388.</div>
     
	<div style="height:24px;width:150px;background-color:#4c7381;float:left;text-align: center;vertical-align: middle;line-height: 24px;">
		&nbsp;&nbsp;&nbsp;
		<a style="color:white;" onmouseover="this.style.color='#0000ff';text-decoration:none" 
		onmouseout="this.style.color='white';" href="#Beginning">Return to beginning</a>
		&nbsp;&nbsp;&nbsp;
	</div><br><br>

	
<!-------------------------------- FOOTER -------------------------------------------->

  <hr>
<h3>Copyright Statement</h3>
<p><h4>Copyright &copy; 2021 by the Society for Music Theory. All rights reserved.</h4></p>
<p class="small">[1] Copyrights for individual items published in  <i>Music Theory Online</i> (<i>MTO</i>) 
are held by their authors. Items appearing in  <i>MTO</i> may be saved and stored in electronic or paper form, and may be shared among individuals for purposes of 
scholarly research or discussion, but may  <i>not</i>  be republished in any form, electronic or print, without prior, written permission from the author(s), and advance 
notification of the editors of  <i>MTO.</i></p>
<p class="small">[2] Any redistributed form of items published in  <i>MTO</i> must include the following information in a form appropriate to the medium in which the items are 
to appear: </p>
<blockquote>
<p class="small">This item appeared in  <i>Music Theory Online</i> in [VOLUME #, ISSUE #] on [DAY/MONTH/YEAR]. It was authored by [FULL NAME, EMAIL ADDRESS], with whose written 
permission it is reprinted here.</p>
</blockquote>
<p class="small">[3] Libraries may archive issues of  <i>MTO</i> in electronic or paper form for public access so long as each issue is stored in its entirety, and no access fee 
is charged. Exceptions to these requirements must be approved in writing by the editors of  <i>MTO,</i> who will act in accordance with the decisions of the Society 
for Music Theory. </p>
<p class="small">This document and all portions thereof are protected by U.S. and international copyright laws. Material contained herein may be copied and/or distributed for research 
purposes only. </p>
     
	<div style="height:24px;width:150px;background-color:#4c7381;float:left;text-align: center;vertical-align: middle;line-height: 24px;">
		&nbsp;&nbsp;&nbsp;
		<a style="color:white;" onmouseover="this.style.color='#0000ff';text-decoration:none" 
		onmouseout="this.style.color='white';" href="#Beginning">Return to beginning</a>
		&nbsp;&nbsp;&nbsp;
	</div><br><br>

	
  	

&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 


<div style="width:55%;float:right"><a href="https://societymusictheory.org">
<img alt="SMT" longdesc="Society for Music Theory" src="https://mtosmt.org/gifs/smtlogo_black.png" width="180"></a></div>
	
<div>
<p style='font-size:1.1rem'>Prepared by Andrew Eason, Editorial Assistant  


<br>
		
			<br>Number of visits:  

		2766
		
	</p><br><br>
</i>		

</div>
</div>
</article>
</body>
</html>

