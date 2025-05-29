 
 

<!-------------------------------- HEADER -------------------------------------------->

	  
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="https://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
<head>

<title> MTO 0.4: McNamee, Octave Expansion and Sonata Form</title>

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
 

<meta name="citation_title" content="Grazyna Bacewicz&rsquo;s Second Piano Sonata (1953): Octave Expansion and Sonata Form">

    <meta name="citation_author" content="McNamee, Ann K.">
      

<meta name="citation_publication_date" content="1993/09/01">
<meta name="citation_journal_title" content="Music Theory Online">
<meta name="citation_volume" content="0">
<meta name="citation_issue" content="4">

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

			
	<h1 style="width:900px; margin-top:1em">Grazyna Bacewicz&rsquo;s Second Piano Sonata (1953): Octave Expansion and Sonata Form

	</h1>
	<div style="width:900px">
			<div style="width:100px;float:right;border:none"><a href="https://www.mtosmt.org/classic/mto.93.0.4/mto.93.0.4.mcnamee.html"><img src="https://www.mtosmt.org/gifs/mto_classic1.gif"></a></div>
				</div>
				<h2><span style="font-weight: 400"><font size="5"><a style="color:black" href="#AUTHORNOTE1">Ann K. McNamee</a></font></span></h2><br><br><p><font size='4'>KEYWORDS: linear analysis, 20th-century sonata forms, Polish folk music</font></p><p><font size='4'>ABSTRACT: If Grazyna Bacewicz&rsquo;s music is so &ldquo;conservative&rdquo; and
&ldquo;neoclassical,&rdquo; why is it so difficult to define the beginning
and ending of the Development in one of her best-known works, the
first movement of her Piano Sonata II? Thirty students and
colleagues arrived at nearly thirty different answers to this
question. I propose a linear analysis to best define the 
Development&rsquo; parameters, an analysis which reveals a large-scale
 octave descent in the bass register. This octave descent spans
neither the major nor the minor scale, but instead prolongs a 
Polish folk mode known as the Podhalean mode.</font></p>			
	<div style='width:800px'><div style='float:right; font-size:1.2rem;'><a href="http://www.mtosmt.org/issues/mto.93.0.4/mto.93.0.4.mcnamee.pdf">PDF text </a> | <a href="http://www.mtosmt.org/issues/mto.93.0.4/mcnamee_examples.pdf">PDF examples </a></div></div>
		<div style="width:850px">
	<div style="text-align:center; font-size: 1.1rem; margin-bottom:2em;margin-top:4em;margin-right:auto;margin-left:auto;width:870px">
		Volume 0, Number 4, September 1993 <br> Copyright &#0169; 1993 Society for Music Theory	</div>
	</div>

<hr style="width:850px"><br>
<section>
<!-------------------------------- ARTICLE BODY (begin) -------------------------------------->

<p style="text-align: center"><b>INTRODUCTION</b></p><p>
[1] Internationally acclaimed as both a concert violinist and a
composer, Gra&#x017C;yna Bacewicz (1909&ndash;1969) holds a place in history
as &ldquo;the greatest woman composer of her time, and the most 
prolific female composer of all time.&rdquo;<sup><a name="FN1REF" href="#FN1" id="footnote1">(1)</a></sup> Her national and
international awards for composition are numerous, reaching their
peak during the 1950&rsquo;s. In terms of Polish music history,
Bacewicz succeeded Szymanowski in the leadership role in her
 country, before relinquishing that position to Lutoslawski and 
Penderecki. Her relative obscurity in the U.S. may be due to the
conservative language of her music, reflecting her choice to
conform to the political pressures of her times. Bacewicz&rsquo;s music
most often receives the adjectives &ldquo;neoclassical,&rdquo;
&ldquo;conservative,&rdquo; and &ldquo;influenced by Polish folk music.&rdquo; Perhaps
 this apparent passivity was of less interest to Americans than 
the rebelliousness and modernism of Lutoslawski. </p>

<p>[2] Whatever the reasons for the previous lack of exposure, one
now finds increasing interest in the U.S. in the music of this 
outstanding composer. New recordings, books, and articles appear
with growng frequency.<sup><a name="FN2REF" href="#FN2" id="footnote2">(2)</a></sup> However, very little has yet to appear 
in the way of detailed analysis. A piece which is perhaps the
most readily available, beautiful, and representative of
Bacewicz&rsquo;s work is the Second Piano Sonata, composed in 1953.
With the adjectives conservative and neoclassical in mind, one
might expect that a formal analysis of the first movement of this
 piano sonata would be straightforward. After discussing the
question of form with about 30 students and colleagues, I learned
with each differing answer that the exact form causes great
confusion. Not about whether or not the movement is in sonata
form&mdash;that was agreed to by all. But confusion arose as to 
where the Development begins and ends. Perhaps Bacewicz&rsquo;s music 
is more &ldquo;neo&rdquo; than &ldquo;Classical,&rdquo; perhaps more innovative than 
previously thought, while still conforming to the political
 demands of the day.</p>

<p>[3] The present article offers work in progress. Its focus is
extremely narrow, that of finding the exact parameters of the 
Development section of the first movement of Bacewicz&rsquo;s Second 
Piano Sonata. In order to define the form, I offer a combination 
of linear analysis and modal analysis, as well as a glimpse at
Bacewicz&rsquo;s sketch material. I propose that a large-scale
prolongation of an octave defines the Development section, 
overshadowing thematic coincidences. Because the essay is online, 
I hope that this topic, which has already generated many
differing responses, will continue to spark discussion in an
electronic forum.</p>

<p>[4] The part of the score needed for this discussion can be found
in Examples 1 and 2a&ndash;2d. For the entire score, see James 
Briscoe&rsquo;s <i>Historical Anthology of Music by Women</i>, which
 contains all movements of the sonata.<sup><a name="FN3REF" href="#FN3" id="footnote3">(3)</a></sup> The sonata has been 
recorded by the following four pianists: 1) Anna Briscoe, on the 
companion cassettes to the <i>Historical Anthology of Music by
Women</i>, 2) Nancy Fierro, Avant AV 1012, 3) Krystian Zimerman, 
Muza SX 1510, and 4) Regina Smendzianka, Muza SXL 0977. Another 
alternative for hearing the piece is requesting that I send it to 
you electronically.<sup><a name="FN4REF" href="#FN4" id="footnote4">(4)</a></sup></p>

<p>[5] I will begin with a brief discussion of the opening phrases
 of the Exposition, then look for the start of the Development.
After that formal point has been established, the start of the
 Recapitulation will be discussed. I will then consider the
structure of the Development as a whole.</p>
<p style="text-align: center"><b>Exposition and the Beginning of the Development</b></p>

            <div style="width:400px;float:right;border:none;margin-left:30px">
                
<p class='fullwidth' style="text-align: center; margin-top:0em"><b>Example 1</b></p><p class='fullwidth' style="text-align: center; margin-bottom:0em"><a class='youtube'  target="blank" href="mcnamee_examples.php?id=0&nonav=true"><img border="1" alt="Example 1 thumbnail" src="mcnamee_ex1_small.png"></a></p><p class='fullwidth' style="text-align: center; margin-top:0em"><font size="2">(click to enlarge)</font></p>                
<p class='fullwidth' style="text-align: center; margin-top:0em"><b>Example 2</b></p><p class='fullwidth' style="text-align: center; margin-bottom:0em"><a class='youtube'  target="blank" href="mcnamee_examples.php?id=1&nonav=true"><img border="1" alt="Example 2 thumbnail" src="mcnamee_ex2a_small.png"></a></p><p class='fullwidth' style="text-align: center; margin-top:0em"><font size="2">(click to enlarge and see the rest)</font></p>                
<p class='fullwidth' style="text-align: center; margin-top:0em"><b>Example 3</b></p><p class='fullwidth' style="text-align: center; margin-bottom:0em"><a class='youtube'  target="blank" href="mcnamee_examples.php?id=5&nonav=true"><img border="1" alt="Example 3 thumbnail" src="mcnamee_ex3_small.png"></a></p><p class='fullwidth' style="text-align: center; margin-top:0em"><font size="2">(click to enlarge)</font></p>            </div>

<p>[6] As shown in <b>Example 1</b>, Bacewicz&rsquo;s Second Piano Sonata opens
with a two-measure Maestoso passage, followed by a change in
tempo to Agitato. A critical feature of the link between these
two musical statements is the bass motion, from the octave B in
measures 1&ndash;2 to the octave E (the tonic). This simple, Classical 
gesture of a dominant to tonic motion also brings in the folk
 elements of the open octave pedal point and a melody which
emphasizes perfect fourths. I view the first two measures as an
anacrusis motive, a slow introduction to the first theme which 
begins in measure 3. The anacrusis motive becomes the central
issue in deciding on the start of the Recapitulation. After the 
anacrusis motive, measures 3&ndash;10 contain the first theme, a full-
bodied, 8-bar Agitato statement.</p>


<p>[7] Although a gap in the score occurs between Examples 1 and 2a
(in order to keep the GIF files to a tolerable amount), the music 
shown in <b>Example 2a</b> introduces the second theme of the
Exposition. I agree with Adrian Thomas that the second theme 
begins at the poco meno in measure 42. Thomas does not propose a
starting measure for the Development, but instead characterizes
Bacewicz as &ldquo;a rhapsodist, constantly reshaping her materials 
through the developmental association of motivic ideas.&rdquo;<sup><a name="FN5REF" href="#FN5" id="footnote5">(5)</a></sup> This 
ambiguity of form is in keeping with Charles Rosen&rsquo;s idea, that,
after Brahms, sonatas often contain an indistinct link from the
Exposition to the Development: &ldquo;In general, it [sonata form] was 
considered a variant of ternary form, an ABA scheme in which the
first A section does not really conclude, and the B section is
characterized by fragmentation, thematic development, and a
dramatic texture.&rdquo;<sup><a name="FN6REF" href="#FN6" id="footnote6">(6)</a></sup> </p>

<p>[8] Thomas and Rosen are perhaps supported by the varied,
seemingly &ldquo;random&rdquo; answers I received for determining the start
 of the Development. Students and colleagues have selected almost
<i>every</i> measure as a possible starting point between measures 65
and 91. I disagree with them all; I apparently alone hear the
 start of the Development at measure 64.<sup><a name="FN7REF" href="#FN7" id="footnote7">(7)</a></sup> Somewhat of a cluster 
of responses seemed to favor measure 70 or 91 as the 
Development&rsquo;s starting point. I believe that a detailed enough 
analysis of the form can yield a very convincing, quite 
innovative, structure. Examples <b>2a</b>, <b>2b</b>, <b>2c</b>, and <b>2d</b> contain the
score for the entire Development section.</p>

<p>[9] <b>Example 3</b> contains the sketch material for the disputed start
of the Development (reprinted by kind permission of the
University of Warsaw Library). Notice that the &ldquo;poco a poco
cresc. ed accelerando,&rdquo; which is buried a bit in the published
score (measures 64&ndash;66, Example 2a), is very prominently set off
in the sketch. This is fortuitous for me, because the start of
the &ldquo;poco a poco cresc.&rdquo; coincides exactly with what I call the 
start of the Development. The sketch material raises several
questions, however. For example, in measure 64 of the published
score, a <nobr><span style= 'letter-spacing:-1px'>C<span style='font-family: Arial Unicode MS, Lucida Sans Unicode;'>&#x266e;</span><span></nobr> appears in the right-hand part. The equivalent 
place in the sketch shows a discrepancy, a <nobr><span style= 'letter-spacing:-0.8px'>C<span style='font-family: Arial Unicode MS, Lucida Sans Unicode;'>&#x266f;</span><span></nobr>. Questions like
this one are part of a more complete analysis of this piece,
which is outside the scope of the present article.</p>
<p>[10] Of course, one should not read too much into the sketch
 material in this instance. Other more compelling reasons support
the idea that the Development begins in measure 64. For example,
the measures preceding the Development, measures 55&ndash;59, contain
the anacrusis motive from measures 1 and 2, signaling an upcoming
 important event. This sense of anticipation is extended in 
measures 61&ndash;63 by a &ldquo;trill,&rdquo; F-<nobr><span style= 'letter-spacing:-1px'>G<span style='font-family: Arial Unicode MS, Lucida Sans Unicode;'>&#x266d;</span><span></nobr> (enharmonically F-<nobr><span style= 'letter-spacing:-0.8px'>F<span style='font-family: Arial Unicode MS, Lucida Sans Unicode;'>&#x266f;</span><span></nobr>), a fifth 
away from B. Taking these anticipatory musical gestures into 
account, the transition to the Development echoes the opening of
the Exposition. In measures 1&ndash;2, the B in the bass introduces the
E tonic of the first theme, also a fifth away. The anacrusis 
motive serves the same function in both important formal points 
of the piece. In fact, both the anacrusis motive and the trill
recur throughout the piece with anticipatory functions. Measures 
8, 41, 52, and 55&ndash;59 contain variants of the anacrusis motive, 
while measures 12, 51, and 53 contain the trill motive, in each 
case, heralding upcoming thematic events.</p>
<p>[11] All of these reasons lead to a clear decision that the 
Development begins in measure 64: the anticipation of an 
important formal event by both the anacrusis and trill motives,
the enharmonic <nobr><span style= 'letter-spacing:-0.8px'>F<span style='font-family: Arial Unicode MS, Lucida Sans Unicode;'>&#x266f;</span><span></nobr>-B fifth motion, paralleling the fifth motion of
the opening of the movement, and a distinctive placement in the
sketches.</p>
<p style="text-align: center"><b>The Recapitulation</b></p><p>
[12] While finding the start of the Development may be difficult
 for recent sonatas, finding the start of the Recapitulation for 
most sonatas, even non-tonal ones, should create less dispute.
For this piece, however, student and colleagues&rsquo; responses 
clustered into three different places: measure 120, 129, or 130.
(See Example 2d for the score.)   </p>
<p>[13] One could argue that the music in measure 129 is so similar
to the very first two measures of the piece that one must say the
 Recapitulation has already begun by this point. Alternatively,
the choice of measure 120 as the start of the Recap presents a
variant on this idea. The dramatic tempo shift in measure 120 
after the long rests in measure 119, the similar melodic content
of perfect fourths and minor sevenths, and the octave B in the
bass all support this analysis. Proponents of this formal scheme 
say that the music of measures 1 and 2 has returned in measures 
120&ndash;129, with an expansion and development. Charles Rosen
mentions three examples of sonatas that contain slow
 introductions with reappearances at the same tempo later in the 
movement.<sup><a name="FN8REF" href="#FN8" id="footnote8">(8)</a></sup></p>

<p>[14] Both of these ideas (measure 120 or 129) for the start of
the Recapitulation are flawed, and flawed for the same reason. 
Measures 1 and 2 do not present the first theme, but rather an 
introduction or anacrusis to the first theme, which does not
begin until measure 3. Reasons for discounting the initial two 
measures as theme 1 are the brevity of melodic statement, the
 dramatic shift of tempo from slow to fast, and, most importantly,
the bass note B which functions as a dominant, leading 
convincingly to E in measure 3. The theme in measure 3 has all of
 the characteristics of a sonata-allegro first theme, the allegro
quality, a convincingly meaty melodic statement, and the tonic E
as its bass. The melodic gestures in the first two measures,
rising perfect fourths and minor sevenths, recur as upbeats at
other points in the movement, at a faster tempo.
  </p>
<p>[15] While I am convinced that the Recapitulation cannot begin 
earlier than measure 130, I heartily agree with the idea that the
first two measures of the piece are expanded in measures 120&ndash;29. 
But that supports the idea of Development or Retransition all the
more, rather than Recapitulation. Of all the responses to my
question of form, my most memorable was, &ldquo;The Development ends in 
measure 119, and the Recapitulation begins in measure 130,&rdquo;
cleverly willing away the sticky issue of the Andante section.</p>
<p style="text-align: center"><b>Linear Analysis and Octave Expansion</b></p><p>
[16] Something equally, if not more, important than all of the
above reasons determines the form of this piece. Beneath the
 surface of the piece&mdash;the themes and the foreground 
progressions&mdash;the linear development and octave expansion at
the middleground level best support the analysis of measures 64&ndash;129 as the Development. &ldquo;Linear development&rdquo; and &ldquo;middleground&rdquo;
immediately conjure up the Schenkerian model, with its large-scale step-wise descents usually in the highest structural voice.
Extending linear analysis to include twentieth-century music,
several theorists have proposed more inclusive ideas of
prolongation. Most prominent among them, Allen Forte proposes
non-tonal prolongations in his many articles on linear
analysis.<sup><a name="FN9REF" href="#FN9" id="footnote9">(9)</a></sup> Other theorists, notably Paul Wilson, Joseph Straus,
and Pieter van den Toorn, discuss linear motion over long spans 
of music in the works of Slavic composers.<sup><a name="FN10REF" href="#FN10" id="footnote10">(10)</a></sup> These
 prolongations illuminate the structures of advanced tonal 
language and of nontonal music, and allow for prolongations of
musical statements other than tonal ones. Registers other than
the highest register may carry equal weight. </p>

            <div style="width:400px;float:right;border:none;margin-left:30px">
                
<p class='fullwidth' style="text-align: center; margin-top:0em"><b>Example 4</b></p><p class='fullwidth' style="text-align: center; margin-bottom:0em"><a class='youtube'  target="blank" href="mcnamee_examples.php?id=6&nonav=true"><img border="1" alt="Example 4 thumbnail" src="mcnamee_ex4_small.png"></a></p><p class='fullwidth' style="text-align: center; margin-top:0em"><font size="2">(click to enlarge and see the rest)</font></p>            </div>

<p>[17] Recognizing the inherent dangers of embarking on this 
slippery slope, I would like to continue down their path and
introduce a modal prolongation of an octave, in the bass
register. This octave expansion not only spans all of the
Development section; it <i>defines</i> the Development section. </p>
<p>[18] <b>Example 4a</b> presents a preliminary version of a linear
analysis of the structure of the entire Development. During the
Development an octave is composed out in the bass, from the B in 
measures 64&ndash;78 to the B in measures 121&ndash;29. One can easily find
 comparable examples in the tonal literature for a Development
section being defined by a middleground prolongation of an
interval.<sup><a name="FN11REF" href="#FN11" id="footnote11">(11)</a></sup> If one searches for a descending B Major or b minor 
scale in the Bacewicz sonata, however, none would surface. A
particularly crucial part of a standard tonal investigation would
be the search for scale-degree 5, <nobr><span style= 'letter-spacing:-0.8px'>F<span style='font-family: Arial Unicode MS, Lucida Sans Unicode;'>&#x266f;</span><span></nobr>. It simply doesn&rsquo;t exist in 
this octave descent. After the appearance of <nobr><span style= 'letter-spacing:-1px'>G<span style='font-family: Arial Unicode MS, Lucida Sans Unicode;'>&#x266d;</span><span></nobr> (<nobr><span style= 'letter-spacing:-0.8px'>F<span style='font-family: Arial Unicode MS, Lucida Sans Unicode;'>&#x266f;</span><span></nobr>) in measures
61&ndash;63, as part of the trill to introduce the Development, <nobr><span style= 'letter-spacing:-0.8px'>F<span style='font-family: Arial Unicode MS, Lucida Sans Unicode;'>&#x266f;</span><span></nobr>disappears. This disappearance seems to negate the possibility of
an octave descent in either B Major or b minor.</p>

<p style="text-align: center"><b>The Podhalean Mode</b></p><p>
[19] I propose a more logical choice for a scale, a Polish folk 
mode called the Podhalean mode, which infuses much of Bacewicz&rsquo;s
and Szymanowski&rsquo;s music. <b>Example 4b</b> shows the pitches of a
descending Podhalean scale on B. As in much of Slavic and Eastern 
European folk music, characteristic features of this mode are the 
raised fourth degree and the lowered seventh degree. Great 
importance is placed on the raised scale-degree 4, a tritone away 
from the tonic. <b>Example 4c</b> shows the same Podhalean scale on B,
but written with enharmonic equivalents.      
	</p>
<p>[20] This enharmonic form of the Podhalean mode appears very 
prominently in the Development. As shown in <b>Example 4d</b>, a 
middleground octave descent in the bass line spans the entire 
Development section. I believe that this middleground descent is
 compelling enough to be the main determining factor of form. The
 start of the Development, in measure 64, presents a B in the
bass. A chromatic passing tone, <nobr><span style= 'letter-spacing:-1px'>B<span style='font-family: Arial Unicode MS, Lucida Sans Unicode;'>&#x266d;</span><span></nobr>, occurs in measures 82&ndash;87,
at an octave below, thereby hinting at the ultimate goal of the
descent, the lower octave. Scale-degree 7, <nobr><span style= 'letter-spacing:-1px'>A<span style='font-family: Arial Unicode MS, Lucida Sans Unicode;'>&#x266e;</span><span></nobr>, appears in
measures 88 and 89, first at the lower octave, and then in 
measure 90 at the upper octave. From a thematic point of view,
 what has been developed so far is the anacrusis motive and the 
trill. In measures 77&ndash;78, the minor third, which first appeared
in measures 11&ndash;12, is developed. This minor third is embellished
 with an upper neighbor in measures 82&ndash;88. The melodic shape,
clearly spelled out in the bass in measure 90, is reminiscent of
the bass in measures 39&ndash;40. Scale-degree 6, <nobr><span style= 'letter-spacing:-0.8px'>G<span style='font-family: Arial Unicode MS, Lucida Sans Unicode;'>&#x266f;</span><span></nobr>, occurs
enharmonically as <nobr><span style= 'letter-spacing:-1px'>A<span style='font-family: Arial Unicode MS, Lucida Sans Unicode;'>&#x266d;</span><span></nobr> in measure 91 and continues its 
structural importance until measure 96. The fermata for this <nobr><span style= 'letter-spacing:-1px'>A<span style='font-family: Arial Unicode MS, Lucida Sans Unicode;'>&#x266d;</span><span></nobr> emphasizes its importance, as does the immediate abandonment
of the low register. A combination of the trill motive and a 
motive from measures 29&ndash;35 is being developed here. I consider 
the B-flats in measures 95&ndash;96 as upper neighbors to <nobr><span style= 'letter-spacing:-1px'>A<span style='font-family: Arial Unicode MS, Lucida Sans Unicode;'>&#x266d;</span><span></nobr> and
the <nobr><span style= 'letter-spacing:-1px'>G<span style='font-family: Arial Unicode MS, Lucida Sans Unicode;'>&#x266e;</span><span></nobr> in measure 97 as passing tones to the F in measure
99.   
	</p>
<p>[21] Scale-degree 5 appears nowhere prominently. Instead, great emphasis is placed on the raised-fourth degree, <nobr><span style= 'letter-spacing:-1px'>F<span style='font-family: Arial Unicode MS, Lucida Sans Unicode;'>&#x266e;</span><span></nobr>(enharmonically <nobr><span style= 'letter-spacing:-0.8px'>E<span style='font-family: Arial Unicode MS, Lucida Sans Unicode;'>&#x266f;</span><span></nobr>) in measures 99&ndash;102. Of critical importance is
 which theme is being developed here. As shown in Example 4d, this 
part of the Development highlights the second theme from the
 Exposition (measures 42ff.). The theme is transposed and 
beautifully augmented in the bass. This occurrence of the second 
theme in the bass highlights the importance of the bass register
for the Development. It also highlights the Classical 
sensibilities of Bacewicz, as this theme begins halfway through 
the Development. A characteristic feature of the folk-influenced 
music of Szymanowski and Bacewicz, this emphasis on raised scale-
degree 4 often replaces scale-degree 5 in the role of the
&ldquo;dominant.&rdquo;<sup><a name="FN12REF" href="#FN12" id="footnote12">(12)</a></sup></p>

<p>[22] If at this point in the Development one searches for scale-
degrees 3 and 2, one is tempted to assign great importance to the
descending <nobr><span style= 'letter-spacing:-1px'>E<span style='font-family: Arial Unicode MS, Lucida Sans Unicode;'>&#x266d;</span><span></nobr> and <nobr><span style= 'letter-spacing:-1px'>D<span style='font-family: Arial Unicode MS, Lucida Sans Unicode;'>&#x266d;</span><span></nobr> in measure 104. Although I do not
want to diminish the importance of this descent in terms of the 
Podhalean scale prolongation, one must place this motion in
context. The second theme of the Exposition has a melody which 
extends from measure 44 all the way to 48 (highlighted by 
Bacewicz&rsquo;s phrase marking&mdash;both in the published score and in
 the sketches&mdash;which does not end until measure 48). The ending 
gesture of this theme is a stepwise descent. I hear that portion
of the theme being developed in measures 103 ff., in fact,
perhaps even being developed until the goal of the low B is
reached.  
	</p>
<p>[23] Great anticipation of the Recapitulation begins in measure 
105. The two-note motive develops both the trill idea and part of
the theme from measure 29 (previously developed in measures
91ff.). A chromatic rising motion in the upper voice in measures
115&ndash;118 has appeared many times before. This chromatic figure
first appears in the middle voice in measures 2&ndash;7 (especially in 
measure 6), as an accompaniment to the first theme. It is
 inverted in measures 41&ndash;47, as an accompaniment to the second
theme. This chromatic figure begins the Development, in measures
64, 66, and 68, as part of a call-and-response juxtaposition with
the trill figure in measure 65 and the fourths and sevenths
figure in measures 67 and 69! The chromatic motive convincingly 
accompanies the arrival of B in the bass, which occurs in 
measures 115&ndash;119, but in the wrong, higher, octave. Or is it 
wrong? Perhaps the higher octave B in the bass during these
 measures, moving to the lower octave B  at the Andante in measure 
121, emphasizes linearly the vertical B octave itself. Put 
another way, the B-B motion summarizes the entire Development,
 and its linear expansion of that octave.
	</p>
<p>[24] The Development is not complete, therefore, without the 
arrival of the lowest B octave. After its arrival in measure 120,
B structures the harmony over the next nine measures, creating an
enormous development of the opening two measures of the piece. 
This long B is finally resolved to an E in measure 130. The 
Development is complete, the linear descent of an octave
accomplished, and the Recapitulation perfectly prepared!<sup><a name="FN13REF" href="#FN13" id="footnote13">(13)</a></sup></p>

<p style="text-align: center"><b>Conclusion</b></p><p>
[25] During the height of creative repression in Poland after the 
War, Bacewicz chose to comply with Soviet directives and to use 
traditional forms and Polish idioms for her compositions. The 
neoclassicism in her music is obvious; no one hears this first
 movement as anything other than sonata-allegro form. Yet, when
pressed for specifics, the &ldquo;Classicism&rdquo; has more depth than at
first glance; the exact form is not self-evident. Using my
 analysis, we find an extraordinarily balanced movement, with
 about two minutes of music each for the Exposition, Development,
and the Recapitulation.  Halfway through the Development, the
second theme appears in the bass. The prolonged bass pitch for
the second theme is <nobr><span style= 'letter-spacing:-1px'>F<span style='font-family: Arial Unicode MS, Lucida Sans Unicode;'>&#x266e;</span><span></nobr>, a tritone away from B, with its 
own internal suggestion of symmetry&mdash;splitting the octave in
half. This elegantly balanced Classical architecture supports an 
innovative, multi-levelled use of the Podhalean mode.</p>
<p>[26] Many examples of folk influence occur in this piece. In
measures 1&ndash;2, the slow introduction, great melodic emphasis is 
placed on the perfect fourth. This rising fourth generates the
 second theme of the Exposition by being filled in. Also, as shown 
literally in measures 1&ndash;2, two perfect fourths in succession
 create a rising minor seventh. This minor seventh echoes the
lowered seventh scale degree of the Podhalean mode. The seventh
also serves to intertwine the older folk idiom with the modern 
dissonance of exposed sevenths. As Adrian Thomas states so well,
Bacewicz&rsquo;s music is not formulaic.<sup><a name="FN14REF" href="#FN14" id="footnote14">(14)</a></sup> Enter the term
&ldquo;rhapsodist,&rdquo; a term which begs for clarification.</p>

<p>[27] Quite hidden to both characterizations of &ldquo;rhapsodist&rdquo; and
&ldquo;folk-influenced&rdquo; is the large-scale expansion of the Podhalean 
mode throughout the Development section. While the rhapsodist 
seems to wander astray, the classicist subtly crafts a 
beautifully centered art form. The folk quality, reminiscent of 
Szymanowski&rsquo;s last pieces, unfolds very differently for Bacewicz
than for Szymanowski.</p>
<p>[28] As research continues, perhaps a new legacy for Bacewicz 
will take shape. The pejorative implications of the labels
&ldquo;formal,&rdquo; &ldquo;conservative,&rdquo; and &ldquo;non-innovative&rdquo; may yield to an
assessment of her music on its own terms, peacefully coexisting
 with the non-innovative music of her alphabetical neighbor, Bach.
 In fact, with respect to multilevel, modal structures, Bacewicz
is indeed innovative. The first two measures of the Second Piano 
Sonata, with its vertical B octave in the bass moving to the E
and to theme 1 in measure 3, anticipates the entire Development
section. The Development takes the bass octave and prolongs it 
linearly by means of the Podhalean mode. This large-scale descent
creates a remarkable middleground structure.
	</p>
<p>[29] I view the geneology in Polish music not as Bacewicz&rsquo;s being 
a disciple of Szymanowski (just as Szymanowski was not a
&ldquo;disciple&rdquo; of Chopin), but as a successor to the throne. During 
the 1950&rsquo;s, Bacewicz was Poland&rsquo;s leading composer, male or
 female. With further analysis, continued exposure and attention, 
Bacewicz&rsquo;s music may come to be viewed in a similar light to the 
neoclassical work of Bartok.<sup><a name="FN15REF" href="#FN15" id="footnote15">(15)</a></sup> </p>

<p>[30] Perhaps consensus can be reached that Bacewicz&rsquo;s sonata is 
more &ldquo;neo&rdquo; than &ldquo;Classical&rdquo; in its use of Polish folk idioms,
more rhapsodic than formulaic in its emotional content, and, at 
the same time, less rhapsodic and more formally structured in
terms of thematic development at the middleground. The beautiful
balance heard throughout many levels of the piano sonata brings 
an elegance of form which perfectly complements the concentrated,
 dramatic, virtuosic, and seemingly improvisitional quality of the 
piece. I like to imagine that Bacewicz, while satisfying the
 bureaucrats in power at the time, was able to save some 
individualism for herself.<sup><a name="FN16REF" href="#FN16" id="footnote16">(16)</a></sup></p></p>

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
	
	Ann K. McNamee<br>
	Swarthmore College<br>Swarthmore, PA 19081<br><a href="mailto:amcname1@cc.swarthmore.edu">amcname1@cc.swarthmore.edu</a><br>	
</p>
	
       
	<div style="height:24px;width:150px;background-color:#4c7381;float:left;text-align: center;vertical-align: middle;line-height: 24px;">
		&nbsp;&nbsp;&nbsp;
		<a style="color:white;" onmouseover="this.style.color='#0000ff';text-decoration:none" 
		onmouseout="this.style.color='white';" href="#Beginning">Return to beginning</a>
		&nbsp;&nbsp;&nbsp;
	</div><br><br>

	
<!-------------------------------- Works Cited List -------------------------------------------->

		
<!-------------------------------- Footnotes List -------------------------------------------->

		
	<hr>
	
	<h3><a name="Footnotes">Footnotes</a></h3>
	
	<p><a name="FN1">1.</a> Rosen, Judith, <i>Gra&#x017C;yna Bacewicz: Her Life and Works</i>, Polish 
Music History Series, vol. 2 (Los Angeles: University of Southern
 California, 1984)<br><a href="#FN1REF">Return to text</a></p><p><a name="FN2">2.</a> In English sources, four scholars have done significant work
on Bacewicz&rsquo;s music.  Pioneering work was done by Judith Rosen in 
&ldquo;Gra&#x017C;yna Bacewicz: Evolution of a Composer,&rdquo; as part of <i>Musical 
Woman, An International perspective, vol. 1</i> (Westport, CT and
 London: Greenwood, 1983, pub. 1984), 105&ndash;17.  In the same
publication, an article about two of Bacewicz&rsquo;s seven string 
quartets appears, written by Elizabeth Wood, &ldquo;Gra&#x017C;yna Bacewicz:
Form, Syntax, Style,&rdquo; 118&ndash;27. Judith Rosen authored the first 
monograph in English, cited in footnote 1. Next in that series is 
Thomas Adrian&rsquo;s <i>Gra&#x017C;yna Bacewicz: Chamber and Orchestral Music</i>,
Polish Music History Series, vol. 3 (Los Angeles: University of 
Southern California, 1985), which contains an excellent 
bibliography on pages 119&ndash;21.  A recent publication is Sharon 
Guertin Shafer&rsquo;s <i>The Contribution of Gra&#x017C;yna Bacewicz (1909&ndash;
1969) to Polish Music</i> (Lewiston, N.Y.: E. Mellen Press, 1992),
which discusses Bacewicz&rsquo;s songs.<br>All of the above sources taken together add up to only 319 
pages; research has just begun in the West.<br><a href="#FN2REF">Return to text</a></p><p><a name="FN3">3.</a> <i>Historical Anthology of Music by Women</i> James Briscoe, ed.
(Bloomington: Indiana University Press, 1987), 298&ndash;318. The two 
pages preceding the piano sonata contain excellent commentary on
the piece by Adrian Thomas. Examples 1 and 2a&ndash;2d have been 
reprinted by kind permission of Polskie Wydawnictwo Muzyczne.<br>
	Another excellent two-page commentary on Bacewicz can be 
found in <i>Women and Music: A History</i> Karin Pendle, ed.
(Bloomington: Indiana University Press, 1991), 197&ndash;99.<br><a href="#FN3REF">Return to text</a></p><p><a name="FN4">4.</a> If you e-mail me directly at amcname1.cc.swarthmore.edu I will 
attempt to send you the six minutes of music in the FTP format. 
Be forewarned that you must have at least 6 megabytes of memory 
available to receive this amount of sound over the network. This 
procedure is possible because of the kind permission of Indiana 
University Press.<br><a href="#FN4REF">Return to text</a></p><p><a name="FN5">5.</a> Thomas, <i>Historical Anthology of Music by Women</i>, 298.<br><a href="#FN5REF">Return to text</a></p><p><a name="FN6">6.</a> Rosen, Charles, <i>Sonata Forms [revised edition]</i> (New York and 
London: W. W. Norton &amp; Co., 1988), 403.<br><a href="#FN6REF">Return to text</a></p><p><a name="FN7">7.</a> One respondent, a fifth-semester theory student, came the
closest to hearing the piece the way I do, choosing measure 65 
for the beginning of the Development. That student was Roxanna
Glass, now a doctoral candidate at CUNY-Graduate Center.<br><a href="#FN7REF">Return to text</a></p><p><a name="FN8">8.</a> Rosen, Charles, 243. On the same page, Rosen also states, 
&ldquo;They [slow introductions] are best viewed rhythmically as large-
scale upbeats, and harmonically the dominant pedal is the most 
important element in their structure&mdash;and in their emotional effect as well, as it creates a sense of something about to 
happen.&rdquo;<br><a href="#FN8REF">Return to text</a></p><p><a name="FN9">9.</a> Bibliographies for this relatively new direction in analyzing 
non-tonal and extended tonal music can be found at the end of 
Allen Forte, &ldquo;New Approaches to the Linear Analysis of Music,&rdquo;
<i>Journal of the American Musicological Society</i> 41/2 (1988): 315&ndash;
48 and Allen Forte, &ldquo;Concepts of Linearity in Schoenberg&rsquo;s Atonal 
Music: A Study of the Op. 15 Song Cycle,&rdquo; <i>Journal of Music
Theory</i> 36/2 (1992): 285&ndash;382.<br><a href="#FN9REF">Return to text</a></p><p><a name="FN10">10.</a> Wilson, Paul, <i>The Music of Bela Bartok</i> (New Haven and
London: Yale University Press, 1992). Straus, Joseph N.,
<i>Introduction to Post-Tonal Theory</i> (Englewood Cliffs: Prentice-
Hall, 1991). van den Toorn, Pieter, <i>The Music of Igor 
Stravinsky</i> (New Haven and London: Yale University Press, 1984).<br><a href="#FN10REF">Return to text</a></p><p><a name="FN11">11.</a> An especially beautiful example of an unfolded interval which
spans the entire Development section can be found in Heinrich 
Schenker, <i>Five Graphic Music Analyses</i> (New York: Dover
Publications, Inc., 1969), 40&ndash;43. The Haydn sonata in this
 example recurs as Figure 62 in Schenker&rsquo;s <i>Free Composition</i>
trans. and ed. by Ernst Oster (New York and London: Longman Inc.,
1979), with some discussion on page 64.<br><a href="#FN11REF">Return to text</a></p><p><a name="FN12">12.</a> Talk of the tritone as &ldquo;dominant&rdquo; immediately brings to mind 
Erno Lendvai&rsquo;s axis system, as described in <i>Bela Bartok: An
Analysis of his Music</i> (London: Kahn &amp; Averill, 1971). In order
to actually understand Lendvai&rsquo;s ideas, one should read the
Appendix &ldquo;Erno Lenvai and the Axis System&rdquo; in Wilson&rsquo;s book, <i>The
Music of Bela Bartok</i>, 203&ndash;208. <br>
	Lendvai refers to the Podhalean mode as the acoustic or 
overtone scale (Lendvai, 67). Another name for this mode is
&ldquo;heptatonia seconda&rdquo; (Wilson, 27).<br><a href="#FN12REF">Return to text</a></p><p><a name="FN13">13.</a> Does it make any sense for Bacewicz to have structured the
 Development in this way, that registral expansion is supreme?
 Bacewicz was a world-class violinist, concertizing throughout 
Europe. It is possible that her sensitivity to register developed 
through her string playing. It is also possible that the 
expansion of the bass register, so critical to solo violin music,
may have influenced her piano writing.<br><a href="#FN13REF">Return to text</a></p><p><a name="FN14">14.</a> Thomas especially dislikes the &ldquo;logic of form&rdquo; generality. &ldquo;&lsquo;Logic of
 form,&rsquo; on the other hand, is a particular and oft-repeated nonsense.  As a 
compositional attribute it is intrinsically indefinable, and few composers 
would relish such a label when unaccompanied by an appraisal of the ideas
that create the form.&rdquo; (<i>Gra&#x017C;yna Bacewicz: Chamber and Orchestral Music</i>,
117).<br><a href="#FN14REF">Return to text</a></p><p><a name="FN15">15.</a> Paul Wilson convincingly analyzes Bartok&rsquo;s Piano Sonata with
several levels of pitch-class sets linked to levels of prolonged
 linear motion (<i>The Music of Bela Bartok</i>, 55&ndash;84). An analysis of 
Bacewicz&rsquo;s sonata using set theory along with linear analysis is 
in progress, but outside the scope of this article.<br><a href="#FN15REF">Return to text</a></p><p><a name="FN16">16.</a> I would like to thank Lee Rothfarb, Michael Marissen, and
 George Huber for their help with this article.<br><a href="#FN16REF">Return to text</a></p><div id="fndiv1" class="flyoverdiv">Rosen, Judith, <i>Gra&#x017C;yna Bacewicz: Her Life and Works</i>, Polish 
Music History Series, vol. 2 (Los Angeles: University of Southern
 California, 1984)</div><div id="fndiv2" class="flyoverdiv">In English sources, four scholars have done significant work
on Bacewicz&rsquo;s music.  Pioneering work was done by Judith Rosen in 
&ldquo;Gra&#x017C;yna Bacewicz: Evolution of a Composer,&rdquo; as part of <i>Musical 
Woman, An International perspective, vol. 1</i> (Westport, CT and
 London: Greenwood, 1983, pub. 1984), 105&ndash;17.  In the same
publication, an article about two of Bacewicz&rsquo;s seven string 
quartets appears, written by Elizabeth Wood, &ldquo;Gra&#x017C;yna Bacewicz:
Form, Syntax, Style,&rdquo; 118&ndash;27. Judith Rosen authored the first 
monograph in English, cited in footnote 1. Next in that series is 
Thomas Adrian&rsquo;s <i>Gra&#x017C;yna Bacewicz: Chamber and Orchestral Music</i>,
Polish Music History Series, vol. 3 (Los Angeles: University of 
Southern California, 1985), which contains an excellent 
bibliography on pages 119&ndash;21.  A recent publication is Sharon 
Guertin Shafer&rsquo;s <i>The Contribution of Gra&#x017C;yna Bacewicz (1909&ndash;
1969) to Polish Music</i> (Lewiston, N.Y.: E. Mellen Press, 1992),
which discusses Bacewicz&rsquo;s songs.<br>All of the above sources taken together add up to only 319 
pages; research has just begun in the West.</div><div id="fndiv3" class="flyoverdiv"><i>Historical Anthology of Music by Women</i> James Briscoe, ed.
(Bloomington: Indiana University Press, 1987), 298&ndash;318. The two 
pages preceding the piano sonata contain excellent commentary on
the piece by Adrian Thomas. Examples 1 and 2a&ndash;2d have been 
reprinted by kind permission of Polskie Wydawnictwo Muzyczne.<br>
	Another excellent two-page commentary on Bacewicz can be 
found in <i>Women and Music: A History</i> Karin Pendle, ed.
(Bloomington: Indiana University Press, 1991), 197&ndash;99.</div><div id="fndiv4" class="flyoverdiv">If you e-mail me directly at amcname1.cc.swarthmore.edu I will 
attempt to send you the six minutes of music in the FTP format. 
Be forewarned that you must have at least 6 megabytes of memory 
available to receive this amount of sound over the network. This 
procedure is possible because of the kind permission of Indiana 
University Press.</div><div id="fndiv5" class="flyoverdiv">Thomas, <i>Historical Anthology of Music by Women</i>, 298.</div><div id="fndiv6" class="flyoverdiv">Rosen, Charles, <i>Sonata Forms [revised edition]</i> (New York and 
London: W. W. Norton &amp; Co., 1988), 403.</div><div id="fndiv7" class="flyoverdiv">One respondent, a fifth-semester theory student, came the
closest to hearing the piece the way I do, choosing measure 65 
for the beginning of the Development. That student was Roxanna
Glass, now a doctoral candidate at CUNY-Graduate Center.</div><div id="fndiv8" class="flyoverdiv">Rosen, Charles, 243. On the same page, Rosen also states, 
&ldquo;They [slow introductions] are best viewed rhythmically as large-
scale upbeats, and harmonically the dominant pedal is the most 
important element in their structure&mdash;and in their emotional effect as well, as it creates a sense of something about to 
happen.&rdquo;</div><div id="fndiv9" class="flyoverdiv">Bibliographies for this relatively new direction in analyzing 
non-tonal and extended tonal music can be found at the end of 
Allen Forte, &ldquo;New Approaches to the Linear Analysis of Music,&rdquo;
<i>Journal of the American Musicological Society</i> 41/2 (1988): 315&ndash;
48 and Allen Forte, &ldquo;Concepts of Linearity in Schoenberg&rsquo;s Atonal 
Music: A Study of the Op. 15 Song Cycle,&rdquo; <i>Journal of Music
Theory</i> 36/2 (1992): 285&ndash;382.</div><div id="fndiv10" class="flyoverdiv">Wilson, Paul, <i>The Music of Bela Bartok</i> (New Haven and
London: Yale University Press, 1992). Straus, Joseph N.,
<i>Introduction to Post-Tonal Theory</i> (Englewood Cliffs: Prentice-
Hall, 1991). van den Toorn, Pieter, <i>The Music of Igor 
Stravinsky</i> (New Haven and London: Yale University Press, 1984).</div><div id="fndiv11" class="flyoverdiv">An especially beautiful example of an unfolded interval which
spans the entire Development section can be found in Heinrich 
Schenker, <i>Five Graphic Music Analyses</i> (New York: Dover
Publications, Inc., 1969), 40&ndash;43. The Haydn sonata in this
 example recurs as Figure 62 in Schenker&rsquo;s <i>Free Composition</i>
trans. and ed. by Ernst Oster (New York and London: Longman Inc.,
1979), with some discussion on page 64.</div><div id="fndiv12" class="flyoverdiv">Talk of the tritone as &ldquo;dominant&rdquo; immediately brings to mind 
Erno Lendvai&rsquo;s axis system, as described in <i>Bela Bartok: An
Analysis of his Music</i> (London: Kahn &amp; Averill, 1971). In order
to actually understand Lendvai&rsquo;s ideas, one should read the
Appendix &ldquo;Erno Lenvai and the Axis System&rdquo; in Wilson&rsquo;s book, <i>The
Music of Bela Bartok</i>, 203&ndash;208. <br>
	Lendvai refers to the Podhalean mode as the acoustic or 
overtone scale (Lendvai, 67). Another name for this mode is
&ldquo;heptatonia seconda&rdquo; (Wilson, 27).</div><div id="fndiv13" class="flyoverdiv">Does it make any sense for Bacewicz to have structured the
 Development in this way, that registral expansion is supreme?
 Bacewicz was a world-class violinist, concertizing throughout 
Europe. It is possible that her sensitivity to register developed 
through her string playing. It is also possible that the 
expansion of the bass register, so critical to solo violin music,
may have influenced her piano writing.</div><div id="fndiv14" class="flyoverdiv">Thomas especially dislikes the &ldquo;logic of form&rdquo; generality. &ldquo;&lsquo;Logic of
 form,&rsquo; on the other hand, is a particular and oft-repeated nonsense.  As a 
compositional attribute it is intrinsically indefinable, and few composers 
would relish such a label when unaccompanied by an appraisal of the ideas
that create the form.&rdquo; (<i>Gra&#x017C;yna Bacewicz: Chamber and Orchestral Music</i>,
117).</div><div id="fndiv15" class="flyoverdiv">Paul Wilson convincingly analyzes Bartok&rsquo;s Piano Sonata with
several levels of pitch-class sets linked to levels of prolonged
 linear motion (<i>The Music of Bela Bartok</i>, 55&ndash;84). An analysis of 
Bacewicz&rsquo;s sonata using set theory along with linear analysis is 
in progress, but outside the scope of this article.</div><div id="fndiv16" class="flyoverdiv">I would like to thank Lee Rothfarb, Michael Marissen, and
 George Huber for their help with this article.</div>	
	   
	<div style="height:24px;width:150px;background-color:#4c7381;float:left;text-align: center;vertical-align: middle;line-height: 24px;">
		&nbsp;&nbsp;&nbsp;
		<a style="color:white;" onmouseover="this.style.color='#0000ff';text-decoration:none" 
		onmouseout="this.style.color='white';" href="#Beginning">Return to beginning</a>
		&nbsp;&nbsp;&nbsp;
	</div><br><br>

	
<!-------------------------------- FOOTER -------------------------------------------->

	<hr>
<h3>Copyright Statement</h3>
<p><h4>Copyright &copy; 1993 by the Society for Music Theory. All rights reserved.</h4></p>
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
<p style='font-size:1rem'>Prepared by Natalie Boisvert, Cynthia Gonzales, and Rebecca Flore, Editorial Assistants  


<br>
		
	
		
	</p><br><br>
</i>		

</div>
</div>
</article>
</body>
</html>

