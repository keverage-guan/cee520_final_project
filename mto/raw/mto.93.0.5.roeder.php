 
 

<!-------------------------------- HEADER -------------------------------------------->

	  
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="https://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> 
<head>

<title> MTO 0.5: Roeder, Semiotic Evalutation</title>

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
 

<meta name="citation_title" content="Toward a Semiotic Evaluation of Music Analyses">

    <meta name="citation_author" content="Roeder, John">
      

<meta name="citation_publication_date" content="1993/11/01">
<meta name="citation_journal_title" content="Music Theory Online">
<meta name="citation_volume" content="0">
<meta name="citation_issue" content="5">

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

			
	<h1 style="width:900px; margin-top:1em">Toward a Semiotic Evaluation of Music Analyses

	</h1>
	<div style="width:900px">
			<div style="width:100px;float:right;border:none"><a href="https://www.mtosmt.org/classic/mto.93.0.5/mto.93.0.5.roeder.html"><img src="https://www.mtosmt.org/gifs/mto_classic1.gif"></a></div>
				</div>
				<h2><span style="font-weight: 400"><font size="5"><a style="color:black" href="#AUTHORNOTE1">John Roeder</a></font></span></h2><br><br><p><font size='4'>KEYWORDS: analysis, semiotics, Eco, pc-set theory, graphical analysis, Schumann, Schubert</font></p><p><font size='4'>ABSTRACT: Eco's theory of codes provides the basis for analyzing
the structure of meaning in three contrasting types of music-
analytical representation.  An evaluation of the pitch-class-integer code highlights the essential arbitrariness of the links
between music and mathematics.  Graphical representations of
music are also evaluated with reference to a computer program
designed to represent musical data in any conceivable graphical
form.  Lastly the paper postulates conditions under which the
literary musical criticism of the Romantic era may have specific
musical denotation; accordingly, Schumann's imagistic review of
Schubert's German Dances, Op. 33, receives exegesis.</font></p>			
	<div style='width:800px'><div style='float:right; font-size:1.2rem;'><a href="http://www.mtosmt.org/issues/mto.93.0.5/mto.93.0.5.roeder.pdf">PDF text </a> | <a href="http://www.mtosmt.org/issues/mto.93.0.5/roeder_examples.pdf">PDF examples </a></div></div>
		<div style="width:850px">
	<div style="text-align:center; font-size: 1.1rem; margin-bottom:2em;margin-top:4em;margin-right:auto;margin-left:auto;width:870px">
		Volume 0, Number 5, November 1993 <br> Copyright &#0169; 1993 Society for Music Theory	</div>
	</div>

<hr style="width:850px"><br>
<section>
<!-------------------------------- ARTICLE BODY (begin) -------------------------------------->

<p>[1] Semiotics, which describes the structure of meaning, is
grandly comprehensive in scope. Umberto Eco's <i>Theory of
Semiotics</i>, for example, defines a &ldquo;sign&rdquo; as &ldquo;<i>everything</i>, that,
on the grounds of a previously established social convention, can
be taken as <i>something standing for something else</i>&rdquo; (<a href="#eco_1976" id="citation_eco_1976_67dc9bfce839d">Eco 1976</a>,
16; page numbers parenthesized below refer to the same work);
Barthes's writings approximate &ldquo;a translinguistics which examines
all sign systems with reference to linguistic laws&rdquo; (30); and
others' refer to a &ldquo;logic of culture&rdquo; (26&ndash;28) not specifically
linguistic.  Yet supporting these transdisciplinary ambitions
lies a well-developed foundation for discussing some important
problems of specifically musical philosophy and aesthetics.</p>
<p>[2] A question that has dominated most such discussions is &ldquo;What
does music mean?&rdquo; (It motivates earlier important studies by
Coker, Meyer, and Cone as well.) Scholars' responses have
explored the analogies between various modes of music cognition
and various types of semiosis.  (The diversity of these
applications can be observed in <a href="#mccreless_1988" id="citation_mccreless_1988_67dc9bfce83a1">McCreless 1988</a>, <a href="#hatten_1989" id="citation_hatten_1989_67dc9bfce83a3">Hatten 1989</a>,
<a href="#brooks_1980" id="citation_brooks_1980_67dc9bfce83a5">Brooks 1980</a>, <a href="#micznik_1989" id="citation_micznik_1989_67dc9bfce83a7">Micznik 1989</a>, and <a href="#agawu_1991" id="citation_agawu_1991_67dc9bfce83a8">Agawu 1991</a>).  Far fewer studies
analyze the various types of discourse about music, in order to
answer the question &ldquo;What do the signs we use to analyze music
mean?&rdquo;; yet this is an easier question to answer, and more
pressing, for it seems essential that as professional
interpreters of music we should constantly evaluate the accuracy
and efficacy of the discourse we use.  Jean-Jacques Nattiez
(<a href="#nattiez_1990" id="citation_nattiez_1990_67dc9bfce83ac">1990</a>) has recently classified various types of analysis with
respect to Molino's tripartition.  He attributes the differences
among analyses of the same piece to the symbolic nature of the
musical act and the analytical act; however his work to date has
not concentrated on any particular type of discourse.  A more
promising precedent for a semiotic analysis of musical discourse
is Dunsby and Stopford's contrastingly technical and ecumenical
essay (<a href="#dunsby_and_stopford_1981" id="citation_dunsby_and_stopford_1981_67dc9bfce83ae">1981</a>), which shows how Schenkerian analysis qualifies as a
semiotic system by identifying the combinational system of
counterpoint as its basis for signification.</p>
<p>[3] To understand better why evaluating music analysis is
important, and how semiotics can help, let us review some
essentials of Eco's theory, which is the most recent, explicit,
and comprehensive.  Eco regards signification as arising from the
correlation of two distinct formal systems (see his Table 6, p.
53). A <i>syntactic system</i> is &ldquo;a set of signals ruled by internal
combinatory laws<nobr> . . . </nobr>an interplay of empty positions and mutual
oppositions&rdquo; (36).  A <i>semantic</i> system consists of &ldquo;a set of
possible communicative contents&rdquo; (37), typically a culturally-determined set of notions about the continuum of experience (76&ndash;
78).  Each cultural unit in the semantic system &ldquo;&lsquo;exists&rsquo; and is
recognized insofar as there exists another one which is opposed
to it.&rdquo; (73)  That is, semantic and syntactic systems are not
distinguishable by their structure; both systems &ldquo;can subsist
independently of any sort of significant or communicative
purpose, and as such may be studied by information theory or by
various types of generative grammars.&rdquo; (38)  Rather they are
distinguished by their respective functions in signification.  A
<i>sign</i> (or, more properly, a <i>sign-function</i>) arises every time
&ldquo;an element of an expression plane [is] conventionally correlated
to one (or several) elements of a content plane.&rdquo; (48)  Syntactic
systems serve as expression planes,  and semantic systems serve
as content planes in signification.  The expression and content
are called <i>sign-vehicle</i> and <i>sememe</i> (or meaning),
respectively, and their correlation is called <i>denotation</i>.  &ldquo;The
meaning of a sign-vehicle<nobr> . . . </nobr>is a semantic unit posited in a
precise &lsquo;space&rsquo; within a semantic system.&rdquo; (84)  A <i>code</i> is a
collection of sign-functions linking a syntactic system with a
semantic system.  It &ldquo;establishes the correlation of an
expression plane (in its purely formal and systematic aspect)
with a content plane (in its purely formal and systematic
aspect)&rdquo; (50), and so determines &ldquo;that a given array of syntactic
signals refers back<nobr> . . . </nobr>to a given &lsquo;pertinent&rsquo; segmentation of the
semantic system.&rdquo;(36&ndash;37)  <i>Connotation</i> arises from the
&ldquo;superelevation of codes&rdquo; when a &ldquo;signification [is] conveyed by
a previous signification,&rdquo; that is, when &ldquo;the content of the
former signification (along with the units that conveyed it)
becomes the expression of a further content,&rdquo;  by means of a
distinct connotative code (55).  That is, connotation always
entails the existence of a further, formally structured semantic
system.  Moreover, each sign-vehicle &ldquo;possesses certain
syntactical markers (such as Singular, Count etc.) which permit
its combination with other sign-vehicles.&rdquo; These syntactical
markers locate the sign-vehicle by its positions and oppositions
within the syntactical system to which it belongs. The particular
contexts or circumstances in which the sign-function arises also
affect its meaning; &ldquo;a sign-function is established by the code
between a given set of semantic markers and a given set of
syntactic markers, both taken as a whole<nobr> . . . </nobr>The sign-function
is not a marker to marker correlation;  therefore the sign-function is not established on the grounds of a strict and
&lsquo;natural&rsquo; homology between the two functives, but is the result
of an arbitrary coupling.&rdquo; (92)</p>
<p>[4] Eco's theory of sign-function as a correlation of two formal
systems asserts that all our models of music have a common
significational structure. The codes of music analysis correlate
concepts, determined by the conventions of our culture, with the
psychophysical quantities of music. By studying how we correlate
musical quantities with the terms and concepts of various kinds
of music analysis, we can achieve several worthwhile goals. 
Since a semiotic analysis of any particular mode of music
representation entails a structural analysis of theoretical
concepts, it helps to refine their meaning.  We can also
recognize how some historically important types of musical
discourse are indeed analytical, even though they are not
quantitative, or otherwise structured in a way normal to our
contemporary culture.  We can better recognize similarities and
contrasts among different modes of analysis.  And we can define
more precisely the limits of any particular analytical approach. 
To illustrate these purposes, I will treat three contrasting
types of music analysis&mdash;mathematical, graphical, and literary&mdash;as semiotic systems.<sup><a name="FN1REF" href="#FN1" id="footnote1">(1)</a></sup></p>
<p>
[5] The first type of music-analytical discourse we shall
consider is the mathematical one, incorporating the integer model
of pitch applied by Babbitt and others to atonal and twelve-tone
music (<a href="#rahn_1980" id="citation_rahn_1980_67dc9bfce83c9">Rahn 1980</a>).  The semiosis in this model is simple, as
befits an introductory example, but it is instructive
nonetheless.  The integers constitute the expression plane (the
syntactic system), and pitches belong to the content plane (the
semantic system).  The code correlates the two system so that
each integer conventionally denotes a distinct pitch.  The
algebraic structure of the integers is tremendously useful in
describing the combinational resources of the equal-tempered
pitch system. But Rahn (<a href="#rahn_1980" id="citation_rahn_1980_67dc9bfce83cb">1980</a>, 19) warns of a &ldquo;numerological
fallacy&rdquo; lurking in this code: &ldquo;we must carefully determine the
limits of similarity between integers (with their structure) and
pitches (with their possible structures).&rdquo;  Describing the model
semiotically facilitates the determination of those limits.<sup><a name="FN2REF" href="#FN2" id="footnote2">(2)</a></sup> 
(a) Sign-functions are <i>not reflexive</i>; hence integers denote
pitches, but not vice versa.  The integer code does not enable
set theorists to experience numbers when they hear pitches.<sup><a name="FN3REF" href="#FN3" id="footnote3">(3)</a></sup> 
(b) The integer code is an <i>arbitrary</i> convention in several
senses.  Other integers beside 0 could denote C1, as most
theorists recognize.  But the assignment of larger integers to
pitches of greater fundamental frequency is also an arbitrary
convention, according to which positive difference denotes
ascent.  Moreover semiotics helps us recognize that there is a
strong cultural component to this code: it arose in a positivist,
male-dominated academic culture that values certain qualities of
discourse over others.  (c) Since the content plane, the pitches,
is actually a <i>segmentation of the continuum of experience</i>, and
since this segmentation of experience is culturally determined,
the code is only valid with respect to certain Western art music. 
Furthermore it expresses a particular listening competence with
respect to that repertoire, in that the integer 0 denotes
whatever we perceive to be &ldquo;C1&rdquo; about all the possible timbral
and combinational manifestations of that pitch.  (d)  Although
integers are often used in mathematical models to denote
intervals as well as pitch, a denotation of pitches does <i>not</i>
entail a denotation of <i>intervals</i>.  The difference of integers
is integers (this fact is essential to their group structure),
but the distance between pitches is not pitch.  Moreover the two
percepts are different to the extent that we may cognize
intervals but only dimly perceive pitch as such.  So when we use
integers to denote intervals we are using <i>another</i>  distinct and
arbitrary code.  An explicit distinction has been made, to my
knowledge, only by David Lewin (<a href="#lewin_1977" id="citation_lewin_1977_67dc9bfce83cf">1977</a>), who developed a model for
pitch which encodes many of the intervallic properties we
associate with pitch without actually labeling them with integers&mdash;that is, without invoking the integer code normally used.  (e)
Generalizing (d), not all the properties (in fact, <i>none</i> of the
properties) of the integers <i>necessarily</i> denotes properties of
pitches.  In semiotic terms, not all the markers that determine
the syntactic place of an integer with respect to the other
integers correspond to semantic markers that locate a pitch with
respect to other pitches.  That is, not all syntactic markers for
integers have musical meaning.  Conversely,  pitches as we
experience them in actual music take on additional semantic
markers by their position in segments.  Although we obviously
have internal codes for tunes, for progressions, and for
climaxes, the integer code has so sign-functions for these. 
Series and sets of integers seem inadequate as sign-vehicles for
such pitched temporalities in particular, for they do not possess
enough syntactic diversity to account for essential aspects of
our perception.
</p>
<p>[6] Let us analyze another mode of music discourse semiotically. 
Graphs are often used to represent musical structure.  On the
surface many of these notations appear quite divergent in design
and execution, with respect to their underlying theory (<a href="#agawu_1989" id="citation_agawu_1989_67dc9bfce83d1">Agawu 1989</a>) or their representational intent (<a href="#hamel_1989" id="citation_hamel_1989_67dc9bfce83d3">Hamel 1989</a>).  From a
semiotic standpoint, however, they are quite similar, because
they all correlate graphical objects with musical objects.  More
exactly, every graphical music notation incorporates a code that
apportions the elements of a graphical system&mdash;its graphical
objects, their graphical features, and their geometrical relation
in the two-dimensional plane&mdash;to the elements of a musical
system&mdash;its events, their musical features, and their relation
in various musical dimensions.</p>
            <div style="width:400px;float:right;border:none;margin-left:30px">
                
<p class='fullwidth' style="text-align: center; margin-top:0em"><b>Example 1</b>. Three different graphical encodings of a piece by Webern</p><p class='fullwidth' style="text-align: center; margin-bottom:0em"><a class='youtube'  target="blank" href="roeder_examples.php?id=0&nonav=true"><img border="1" alt="Example 1 thumbnail" src="roeder_ex1_small.png"></a></p><p class='fullwidth' style="text-align: center; margin-top:0em"><font size="2">(click to enlarge)</font></p>            </div>

<p>[7] Among many graphical representations the similarities of
semiotic structure run even deeper than this general observation
implies.  As an illustration, consider <b>Example 1</b>, which presents
three different graphical encodings of a piece by Webern. These
representations appear dissimilar, but they share some common
notational conventions that engage the two essential syntactic
markers for a graphic&mdash;its shape and its position on the page. 
In all the representations shown here, a positioned shape denotes
a distinct sonic event in the piece, as characterized by pitch,
instrument, time of attack, and duration.  The shape itself
signifies some property&mdash;such as duration or pitch class&mdash;of
the sonic event that distinguishes it from others.  The various
shapes are positioned in each space primarily according to the
convention that lower-pitched events appear towards the bottom
and later-attacked events appear towards the right of the page. 
This convention is ubiquitous to the extent that when we see any
shapes vertically aligned, we assume that the corresponding music
events are attacked simultaneously.  Similarly we assume that
horizontal proximity signifies temporal and registral contiguity. 
In the pitch-class representation shown in the Example, and in
the simple-score representation, an additional positioning
convention is adduced to place events played by the same
instrument in the same horizontal stratum on the page.  In the
score there are also additional, orienting graphical shapes&mdash;staves, bar lines, and clefs&mdash;and the vertical position of each
event within any given stratum is modified further according to
the conventions of common music notation.  In all these
conventions, then, we observe a hierarchy.  The three
representations all share some basic positioning conventions, but
the more elaborate ones embellish or add upon the simpler ones. 
Notice that this code does <i>not</i> correlate graphics objects with
sound events; rather it correlates the <i>geometric relations</i>
among the graphics objects with <i>musical relations</i> among the
sound events.</p>
<p>[8] Our description of graphical analyses as a hierarchy of
conventions which correlate graphical symbols (and relations)
with musical events (and relations) suggests an efficient way to
program a general-purpose graphical music analysis system for a
computer using new object-oriented computer languages (<a href="#roeder_and_hamel_1989" id="citation_roeder_and_hamel_1989_67dc9bfce84b8">Roeder and Hamel 1989</a>). The semiotic distinction between the syntactic
system and the semantic system is achieved by realizing musical
events and graphical symbols as two distinct systems of objects,
as symbolized in Figure 2b.  In the music-object system, musical
events are represented by their basic psychoacoustical
properties, but they have no graphical characteristics.  Related
music objects belong to a data structure called a piece.  In the
independent graphics-object system graphical objects are
represented by their basic geometric properties, but they have no
musical referent.  Related graphics objects belong to a data
structure called a graphics space, and each different-appearing
display instantiates a distinct class of graphics space.  The
graphics objects of each graphics space, then, are the expression
plane that may signify the music contents of a piece. The sign-function that correlates these graphics-objects with music-objects is an algorithm that translates the properties and
relations of the music objects into properties and relations of
the graphics objects in the graphics space.  Our observation that
some graphic representations hold certain significational
conventions in common  is realized, according to the principles
of object-oriented programming, by defining all graphics spaces
in an inheritance hierarchy, such that each space, along with its
objects, may inherit some of the properties of other spaces and
their objects.  This inheritance manifests the semiotic code that
the complex and simple graphical representations share relative
to music.  The hierarchical definition of graphics space makes
explicit the assumptions underlying each graphic representation&mdash;the semiotic code that apportions graphics objects to music
objects, and geometric relations to musical relations&mdash;helping
the analyst to evaluate the musical meaning of any graphical
relations the representation reveals.</p>
<p>[9] The last mode of analysis to be evaluated as a system of
signification is the literary mode of musical criticism emergent
during the Romantic era.  Many recent studies have attempted to
define processes in Romantic music that are analogous to
narrative strategies (<a href="#newcomb_1987" id="citation_newcomb_1987_67dc9bfce84ba">Newcomb 1987</a>; <a href="#daverio_1990" id="citation_daverio_1990_67dc9bfce84bc">Daverio 1990</a>).  But less
attention has been given to how Romantic music criticism, as
text, might relate to the music to which it refers.  Robert
Schumann's reviews of his contemporaries' music would seem to be
likely candidates for such consideration.  But  several problems
arise when we try to understand these writings as music analysis. 
Narrative theory does not apply satisfactorily to them because
they lack an explicitly narrative structure.  Rather the reviews
typically describe pieces by presenting a sketchy image, or a
static scene lacking temporal development, plot, and sometimes
even action.  Another well-known problem arises in determining
what aspects of the music, if any, these images signify.  Natural
language is very complex semiosis&mdash;Eco describes it as a
&ldquo;system of interconnected codes&rdquo; (91) in which &ldquo; the cultural
units are very seldom formally univocal entities, and are very
frequently what logic calls &lsquo;<i>fuzzy concepts</i>&rsquo;&rdquo;  (82).  Words and
the images they immediate denote are ordinarily so rich in
connotative implications, and require so many markers for their
disambiguation that many modern analysts tend to disdain literary
modes of musical discourse as too imprecise.</p>
<p>[10] However, semiotic theory suggests special conditions under
which such prose could meaningfully represent music.  Sign-functions arise to the extent that the sign-vehicles constitute a
unambiguous syntactic system, that is, to the extent that they
are arranged in clear patterns of positions and oppositions.  If
the images can be construed as constituting an unambiguous
system, then they&mdash;and the relations they connote&mdash;may more
readily function as the expression plane for a musical content. 
Restricting and schematizing images curtails their ambiguity and
thereby enhances their denotative clarity as sign-vehicles.</p>
<p>[11] Remarkably, some of Schumann's imagistic critical prose does
approach the constrained syntax essential to signification.  A
good example is the set of images he invents for Schubert's
<i>Deutsche Taenze und Ecossaisen</i>, Op. 33.  (Readers should refer
to the scores of the dances in, e.g., <a href="#devoto_1992" id="citation_devoto_1992_67dc9bfce84be">DeVoto 1992</a>, and to
Strunk's fairly accurate translation in <a href="#schumann_1836_1965" id="citation_schumann_1836_1965_67dc9bfce84c0">Schumann [1836] 1965</a>,
103&ndash;104.)  Regarding them together, we can observe special
characteristics of both the music and the prose. Schumann's
review presents ten images in the context of a masked ball&mdash;a
highly conventionalized social affair in which the masqueraders
cut themselves off from their everyday contexts and place
themselves in an wholly different, stylized one, in order to act
out their repressed inner desires.  These ten little scenes,
stripped by this restrictive context of any extraneous
connotations we might otherwise attribute to them, polarize, as
sign-vehicles, along various dimensions of relationship. 
Schubert's German dances are tokens of a similarly restricted,
stylized genre, in which small contrasts of texture, harmony,
phrasing, and accent, cut off from the larger continuities in
which they normally participate, are magnified.</p>
<p>[12] This structural mimesis suggests that each of Schumann's
scenes corresponds, in some ways, to the sequentially
corresponding dance in Schubert's set.  It also suggests that Schumann's aphoristic prose signifies not the content and process
within each dance, but rather the semantic-structural position of
each dance with respect to the set as a whole.  Indeed when we
compare the first ten dances to each other certain musical
polarities are apparent. In the interest of space I will focus
just on the most immediately apprehensible differences of
harmonic vocabulary, registral span, and loudness among these
dances, although it proves equally valid&mdash;and interesting&mdash;to
contrast their more elaborate characteristics of texture, and
motivic development.</p>
            <div style="width:400px;float:right;border:none;margin-left:30px">
                
<p class='fullwidth' style="text-align: center; margin-top:0em"><b>Example 2a</b>. Musical Oppositions in Schubert&rsquo;s Op.33</p><p class='fullwidth' style="text-align: center; margin-bottom:0em"><a class='youtube'  target="blank" href="roeder_examples.php?id=1&nonav=true"><img border="1" alt="Example 2a thumbnail" src="roeder_ex2asmall.png"></a></p><p class='fullwidth' style="text-align: center; margin-top:0em"><font size="2">(click to enlarge)</font></p>                
<p class='fullwidth' style="text-align: center; margin-top:0em"><b>Example 2b</b>. Textual Oppositions in Schumann&rsquo;s Review of Op. 33</p><p class='fullwidth' style="text-align: center; margin-bottom:0em"><a class='youtube'  target="blank" href="roeder_examples.php?id=2&nonav=true"><img border="1" alt="Example 2b thumbnail" src="roeder_ex2bsmall.png"></a></p><p class='fullwidth' style="text-align: center; margin-top:0em"><font size="2">(click to enlarge)</font></p>            </div>

<p>[13] The tables in <b>Example 2a</b> show some musical dimensions in
which oppositions can be defined, and indicate by number where
the dances are positioned with respect to each other between the
extremes in each dimension.  The first table compare the dances
by how far apart their independent outer voices get; Dance 8
keeps the voices closest together, while Dance 1 has the widest
span (except for Dance 3, in which the extreme span arises from a
nonstructural doubling of the bass at the cadence).  The second
table groups the dances according to how the dynamics change. 
Dances 6 and 4 keep a constant loudness; Dances 8, 2, 10, 5, and
7 move away from, then return to, a single dynamic; and Dances 1,
3 and 9 finish at a different dynamic from where they start.  The
third table ranks the dances according to their harmonic
complexity.  At one extreme are shown those dances, such as 8 and
2, that simply alternate tonic and dominant.  Dances listed in
the middle of the chart exhibit more diverse, but still diatonic,
harmonies.  Dances located towards the other extreme display more
elaborate harmonic techniques, such as tonicization of secondary
triads (Dances 1 and 10), accented non-chord tones (Dance 5),
beginning and ending in different keys (also Dance 5),  and use
of distinctively chromatic chords (Dances 6 and 10).</p>
<p>[14] Within Schumann's text the sign-vehicles polarize as well
along various connoted dimensions.  The number of characters in
each scene varies from solo to pairs to crowds, as shown in the
first table in <b>Example 2b</b>.  The second table ranks the scenes
according to the amount of action in them.  Scene 6, in which a
hussar stands at attention, has the least action; a number of
scenes combine speech with a little action; and, shown at the
other end of the scale, are scenes 3 and 9 in which there is
clear action without speech.  Also evident among the characters
in the scenes are distinctions of social class.  Some persons are
from the country; at the other social extreme are knights or
nobility associated with the court; and some characters are
anonymous masks.</p>
<p>[15] Schumann's scenes constitute an analysis of Schubert's music
to the extent that the two distinct systems correlate. Most
generally, of course, the prose asserts the musical unity of the
first ten dances by representing them all as scenes within a
single social affair.  An analogous thread of continuity may be
heard in the common-tone links between successive dances: the
initial pitch of each waltz belongs to the tonic triad of the
preceding one.  Also the pitch D6 recurs, often as a registral
high point, in many of these dances.  The dances also obviously
share a number of motives, some of them (such as quarter-eighth-eighth-quarter) common to the genre, and some (such as the F5-D5
motive prominent in Dances 3, 6, and 7, and also important in
Dances 9 and 10) more specific to this set. </p>
<p>[16] But much more specific correlations are evident between the
prose and the music, as indicated by the parenthetical additions
to the titles of the tables in Example 2b.  The number of
characters Schumann places in each scene correlates with the
maximum interval between the structural outer voices during the
corresponding dance.  The type of action in each scene correlates
with the ways dynamics are shaped in each dance.  The social
class and the demeanor the characters in each scene, which
parallel each other, correlate with the degree of harmonic
complexity in the corresponding dance.  Opposition along the axes
for images correlates with opposition along the corresponding
axes for music.  For instance, scenes 1 and 2 contrast strongly
with respect to the number and type of characters, action and
tone.  Dances 1 and 2 also contrast strongly: the widest span of
dance 1 is much greater than that of dance 2, it is much more
complex harmonically, and changes dynamics in a much different
way.  Scenes that are similar in some imagistic dimensions, such
as 2 and 8, correspond to dances that are similar in the
correlated musical dimensions.  Some scenes and dances, such as
6, are consistently near the extremes in their respective
dimensions, while others, notably 10, occupy various positions
with respect to the others in different dimensions.  It is
important to realize that the review does not correlate specific
images themselves with specific musical events, as a naive
program description might try to do.<sup><a name="FN4REF" href="#FN4" id="footnote4">(4)</a></sup> Rather, just as
geometric relations connoted by arbitrary graphic shapes may
signify musical relations, the relations connoted by Schumann's
images signify musical relations.
</p>
<p>[17] An interesting question of pragmatics arises in this
connection.  Why did Schumann choose to give one of his most
extensive literary descriptions to this particular, relatively
generic set of short pieces?  Certainly he was not incapable of
what we would regard as technical commentary.  His famous early
essay on Berlioz's <i>Symphonie fantastique</i> (<a href="#schumann_1946" id="citation_schumann_1946_67dc9bfce84d8">Schumann 1946</a>, 164&ndash;
188) contains a detailed and occasionally scathing critique of
individual chords, voice leading, counterpoint, harmony, tonal
plan of movements, phrase lengths and symmetries.<sup><a name="FN5REF" href="#FN5" id="footnote5">(5)</a></sup>  In some
respects, though, that essay lacks comprehensiveness: Schumann
discusses textural aspects, rhythmic goals, and larger patterns
of dynamics and accent only obliquely or not at all, because the
theoretical terminology was lacking.  One motivation, then,  for
employing literary structure would be to get at oppositions for
which there were not any commonly accepted or easily understood
theoretical terms.</p>
<p>[18] Another motivation is suggested by the special properties of
Schubert's dances.  We have seen that using images to signify
music works best under two reciprocal conditions: that the
connotations of the images are constrained by the overall scene
in which they appear; and that the musical relations are few
enough and well enough defined.  Too many images, too many
connotations, or too many musical relations would cause the
semiosis to become incomprehensible under the sheer multiplicity
of correlations.  In the case of Schubert's music, the
constraints of the dance genre permit the structural features of
these dances to be heard in a system of positions and oppositions
that could not arise in the immensely varied, elaborate processes
of large-scale symphonic works.  These restricted pieces are
better suited than symphonies for imagistic analysis.  And the
unity and structure of the dance set as a whole were more easily,
more correctly&mdash;and perhaps more fully&mdash;signified by such a
correlation of images than by elaborate technical description.</p>
<p>[19] The semiotic properties of literary analysis permit a
critical evaluation of music as well as do other more technical
modes of music analysis.  For example, earlier in the article
that contains this scene, Schumann faults some waltzes of
Thalberg (Op. 4) for being &ldquo;too transparent<nobr> . . . </nobr>and eternally tonic
and dominant, dominant and tonic&rdquo; (<a href="#schumann_1836_1965" id="citation_schumann_1836_1965_67dc9bfce84e7">Schumann [1836] 1965</a>, 103).  Would
not some of Schubert's harmonically and rhythmically simple
dances, such as the second or eighth, receive similar
condemnation?  Our semiotic analysis of Schumann's review helps
us realize that he was criticizing not merely the properties of
the waltzes in isolation but their relations to each other as
part of a system.  His aesthetics valued collections, like
Schubert's, in which simple pieces were set in opposition to more
complex pieces, over uniformly simple sets like Thalberg's.</p>
<p>[20] Schumann renders other aesthetic judgments by the abrupt
close of his review.  Certainly there are elements of closure in
the tenth dance that might have motivated closure in the text. 
Contrary to all previous junctions between dances, the tonic
triads of dances 10 and 11 share no common tones.  The tenth
dance, like the first dance, spans 24 bars rather than the usual
16.  Its recapitulates some of the sequential progressions of
dance 1, and provides the first return of the A tonic.  (Schumann
was very sensitive to unity of key, as we know from his review of
Chopin's Op. 38 Ballade (<a href="#schumann_1946" id="citation_schumann_1946_67dc9bfce84e8">Schumann 1946</a>, 143), and the only
technical term he uses in his otherwise imagistic analysis is the
key designation &ldquo;A major&rdquo;.)  In the text, Florestan's abrupt
departure comes at the moment when the scene he is declaiming
provides elements of recapitulation and closure.  Like the end of
the first scene, the tenth scene reports spoken dialogue after a
crowd (referred to in scene 9).  And the Ursuline's reply&mdash;&ldquo;I
would rather not speak, to be understood&rdquo;&mdash; is both a
commentary on the scene, like the wigged man's comment in the
first dance, and, perhaps, an expression of the futility of
expressing music with words.  In this light Schumann's
termination of the review at this point can be understood as a
subtle criticism of the remainder of the set of dances.  At this
point in the literary analysis the semiotic correlation seems to
have reached saturation; continuing to add images would create
too many new relations and confound the significance obtained by
restricting them.  Schumann  insinuates analogously, by the
correlation of text to music, that the later dances add too many
new relations, spoiling the &ldquo;point of highest enjoyment&rdquo; created
by the closures of the tenth dance, and threatening the musical
unity of the entire set.</p>
<p>[21] In each of the three semiotic systems examined in this
paper, a code is established whereby aspects of musical structure
are signified by the structures of another system&mdash;the
relations of graphical shapes and locations, mathematical
structures, or images connoted by language, appropriately
restricted by context.  These examples substantiate the semiotic
view that all our analyses of music are mediated by codes.  Music
cannot <i>have meaning</i> purely in its own terms, because purely
syntactical, self-referential terms have no significance. To
contemplate music as pure structure, without a code correlating
it to some content plane, approaches the desperate situation in
Kafka's works, as read by Gershom Scholem, &ldquo;in which revelation
appears to be without meaning, in which it still asserts itself,
in which it has validity but no significance&rdquo; (<a href="#benjamin_and_scholem_1989" id="citation_benjamin_and_scholem_1989_67dc9bfce84eb">Benjamin and Scholem 1989</a>, 142).</p>
<p>[22] We conclude, from this semiotic perspective, that music
theorists must play an imperative and active role as a music
semioticians.  Theorists create and codify systems by which music
can be represented and analyzed, that is, by which music can be
understood to have significance.  It may happen in our quest that
we will invent systems that <i>misrepresent</i> music, especially
those aspects of musical structure for which we have no
alternative codes, such as texture and rhythm.  Indeed every
music-theoretical system, like other semiotic systems, &ldquo;can be
used in order to lie&rdquo; (<a href="#eco_1976" id="citation_eco_1976_67dc9bfce84ec">Eco 1976</a>, 7).  Accordingly we must continue to
evaluate the representations and structures we invoke, and
identify the limitations of analytical paradigms that are
accepted by tradition, convention, or default.</p></p>

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
	
	John Roeder<br>
	University of British Columbia<br>School of Music<br>6361 Memorial Road<br>Vancouver, B.C. V6T 1Z2 CANADA<br><a href="mailto:jroeder@unixg.ubc.ca">jroeder@unixg.ubc.ca</a><br>	
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
	
	<div id="citediv_agawu_1991" class="flyoverdiv">Agawu, V. Kofi.  1991.  <i>Playing with Signs</i>.  Princeton:
    Princeton University Press.</div><p style="text-indent: -1em; margin-left: 1em; margin-top: 0em"><a name="agawu_1991"></a>Agawu, V. Kofi.  1991.  <i>Playing with Signs</i>.  Princeton:
    Princeton University Press.</p><div id="citediv_agawu_1989" class="flyoverdiv">Agawu, V. Kofi.  1989.  &ldquo;Schenkerian Notation in Theory and
    Practice.&rdquo;  <i>Music Analysis</i> 8/3: 275&ndash;302.</div><p style="text-indent: -1em; margin-left: 1em; margin-top: 0em"><a name="agawu_1989"></a><span class='sans'>&mdash;&mdash;&mdash;&mdash;&mdash;</span>.  1989.  &ldquo;Schenkerian Notation in Theory and
    Practice.&rdquo;  <i>Music Analysis</i> 8/3: 275&ndash;302.</p><div id="citediv_benjamin_and_scholem_1989" class="flyoverdiv">Benjamin, Walter and Gershom Scholem.  1989. <i>The Correspondence
    of Walter Benjamin and Gershom Scholem: 1932&ndash;1940</i>.  Ed.
    Gershom Scholem.  Trans. Gary Smith and Andre Lefevere.  New
    York: Schocken Books.</div><p style="text-indent: -1em; margin-left: 1em; margin-top: 0em"><a name="benjamin_and_scholem_1989"></a>Benjamin, Walter and Gershom Scholem.  1989. <i>The Correspondence
    of Walter Benjamin and Gershom Scholem: 1932&ndash;1940</i>.  Ed.
    Gershom Scholem.  Trans. Gary Smith and Andre Lefevere.  New
    York: Schocken Books.</p><div id="citediv_brooks_1980" class="flyoverdiv">Brooks, William.  1980.  &ldquo;Competenza Maledetta.&rdquo;  <i>Perspectives of
    New Music</i> 18: 11&ndash;45.</div><p style="text-indent: -1em; margin-left: 1em; margin-top: 0em"><a name="brooks_1980"></a>Brooks, William.  1980.  &ldquo;Competenza Maledetta.&rdquo;  <i>Perspectives of
    New Music</i> 18: 11&ndash;45.</p><div id="citediv_daverio_1990" class="flyoverdiv">Daverio, John.  1990.  &ldquo;Reading Schumann By Way of Jean Paul and
    His Contemporaries.&rdquo; <i>College Music Symposium</i> 30/2: 28&ndash;45.</div><p style="text-indent: -1em; margin-left: 1em; margin-top: 0em"><a name="daverio_1990"></a>Daverio, John.  1990.  &ldquo;Reading Schumann By Way of Jean Paul and
    His Contemporaries.&rdquo; <i>College Music Symposium</i> 30/2: 28&ndash;45.</p><div id="citediv_devoto_1992" class="flyoverdiv">DeVoto, Mark, ed.  1992.  <i>Mostly Short Pieces</i>.  New York:
    Norton.</div><p style="text-indent: -1em; margin-left: 1em; margin-top: 0em"><a name="devoto_1992"></a>DeVoto, Mark, ed.  1992.  <i>Mostly Short Pieces</i>.  New York:
    Norton.</p><div id="citediv_dunsby_and_stopford_1981" class="flyoverdiv">Dunsby, Jonathan and John Stopford. 1981.  &ldquo;The Case for a
    Schenkerian Semiotic.&rdquo;  <i>Music Theory Spectrum</i> 3: 49&ndash;53.</div><p style="text-indent: -1em; margin-left: 1em; margin-top: 0em"><a name="dunsby_and_stopford_1981"></a>Dunsby, Jonathan and John Stopford. 1981.  &ldquo;The Case for a
    Schenkerian Semiotic.&rdquo;  <i>Music Theory Spectrum</i> 3: 49&ndash;53.</p><div id="citediv_eco_1976" class="flyoverdiv">Eco, Umberto.  1976.  <i>A Theory of Semiotics</i>.  Bloomington:
    Indiana University Press.</div><p style="text-indent: -1em; margin-left: 1em; margin-top: 0em"><a name="eco_1976"></a>Eco, Umberto.  1976.  <i>A Theory of Semiotics</i>.  Bloomington:
    Indiana University Press.</p><div id="citediv_hamel_1989" class="flyoverdiv">Hamel, Keith.  1989.  &ldquo;A Design for Music Editing and Printing
    Software Based on Notational Syntax.&rdquo;  <i>Perspectives of New
    Music</i> 27(1): 70&ndash;83.</div><p style="text-indent: -1em; margin-left: 1em; margin-top: 0em"><a name="hamel_1989"></a>Hamel, Keith.  1989.  &ldquo;A Design for Music Editing and Printing
    Software Based on Notational Syntax.&rdquo;  <i>Perspectives of New
    Music</i> 27(1): 70&ndash;83.</p><div id="citediv_hatten_1989" class="flyoverdiv">Hatten, Robert.  1989.  &ldquo;Semiotic Perspectives on Issues in Music
    Cognition.&rdquo;  <i>In Theory Only</i>  11(3): 1&ndash;10.</div><p style="text-indent: -1em; margin-left: 1em; margin-top: 0em"><a name="hatten_1989"></a>Hatten, Robert.  1989.  &ldquo;Semiotic Perspectives on Issues in Music
    Cognition.&rdquo;  <i>In Theory Only</i>  11(3): 1&ndash;10.</p><div id="citediv_lewin_1977" class="flyoverdiv">Lewin, David.  1977.  &ldquo;A Label-Free Development for 12-Pitch-Class
    Systems.&rdquo;  <i>Journal of Music Theory</i> 21/1: 29&ndash;48.</div><p style="text-indent: -1em; margin-left: 1em; margin-top: 0em"><a name="lewin_1977"></a>Lewin, David.  1977.  &ldquo;A Label-Free Development for 12-Pitch-Class
    Systems.&rdquo;  <i>Journal of Music Theory</i> 21/1: 29&ndash;48.</p><div id="citediv_mazzola_1990" class="flyoverdiv">Mazzola, Guerino.  1990.  <i>Geometrie der Toene</i>.  Basel:
    Birkhaeuser.</div><p style="text-indent: -1em; margin-left: 1em; margin-top: 0em"><a name="mazzola_1990"></a>Mazzola, Guerino.  1990.  <i>Geometrie der Toene</i>.  Basel:
    Birkhaeuser.</p><div id="citediv_mccreless_1988" class="flyoverdiv">McCreless, Patrick.  1988.  &ldquo;Roland Barthes's S/Z from a Musical
    Point of View.&rdquo;  <i>In Theory Only</i> 10/7: 1&ndash;24.</div><p style="text-indent: -1em; margin-left: 1em; margin-top: 0em"><a name="mccreless_1988"></a>McCreless, Patrick.  1988.  &ldquo;Roland Barthes's S/Z from a Musical
    Point of View.&rdquo;  <i>In Theory Only</i> 10/7: 1&ndash;24.</p><div id="citediv_micznik_1989" class="flyoverdiv">Micznik, Vera. 1989. <i>Meaning in Gustav Mahler&rsquo;s Music : a Historical and Analytical Study Focusing on the Ninth Symphony</i>. Ph.D. diss. State University of New York at Stony Brook.</div><p style="text-indent: -1em; margin-left: 1em; margin-top: 0em"><a name="micznik_1989"></a>Micznik, Vera. 1989. <i>Meaning in Gustav Mahler&rsquo;s Music : a Historical and Analytical Study Focusing on the Ninth Symphony</i>. Ph.D. diss. State University of New York at Stony Brook.</p><div id="citediv_nattiez_1990" class="flyoverdiv">Nattiez, Jean-Jacques.  1990.  <i>Music and Discourse</i>.  Trans.
    Carolyn Abbate.  Princeton: Princeton University Press.</div><p style="text-indent: -1em; margin-left: 1em; margin-top: 0em"><a name="nattiez_1990"></a>Nattiez, Jean-Jacques.  1990.  <i>Music and Discourse</i>.  Trans.
    Carolyn Abbate.  Princeton: Princeton University Press.</p><div id="citediv_newcomb_1987" class="flyoverdiv">Newcomb, Anthony.  1987.  &ldquo;Schumann and Late Eighteenth-Century
    Narrative Strategies.&rdquo;  <i>19th Century Music</i>  11/2: 164&ndash;174.</div><p style="text-indent: -1em; margin-left: 1em; margin-top: 0em"><a name="newcomb_1987"></a>Newcomb, Anthony.  1987.  &ldquo;Schumann and Late Eighteenth-Century
    Narrative Strategies.&rdquo;  <i>19th Century Music</i>  11/2: 164&ndash;174.</p><div id="citediv_rahn_1980" class="flyoverdiv">Rahn, John.  1980.  <i>Basic Atonal Theory</i>.  New York: Longman.</div><p style="text-indent: -1em; margin-left: 1em; margin-top: 0em"><a name="rahn_1980"></a>Rahn, John.  1980.  <i>Basic Atonal Theory</i>.  New York: Longman.</p><div id="citediv_roeder_and_hamel_1989" class="flyoverdiv">Roeder, John and Keith Hamel.  1989.  &ldquo;A General-Purpose Object-
    Oriented System for Musical Graphics.&rdquo;  <i>Proceedings of the
    1989 International Computer Music Conference</i>.  San
    Francisco: Computer Music Association.  Pp. 260&ndash;263.</div><p style="text-indent: -1em; margin-left: 1em; margin-top: 0em"><a name="roeder_and_hamel_1989"></a>Roeder, John and Keith Hamel.  1989.  &ldquo;A General-Purpose Object-
    Oriented System for Musical Graphics.&rdquo;  <i>Proceedings of the
    1989 International Computer Music Conference</i>.  San
    Francisco: Computer Music Association.  Pp. 260&ndash;263.</p><div id="citediv_schumann_1836_1965" class="flyoverdiv">Schumann, Robert.  1965 [1836].  [Dance Literature].  Trans. by
    Oliver Strunk in <i>Source Readings in Music History, Volume V:
    The Romantic Era</i>.  New York, Norton.</div><p style="text-indent: -1em; margin-left: 1em; margin-top: 0em"><a name="schumann_1836_1965"></a>Schumann, Robert.  1965 [1836].  [Dance Literature].  Trans. by
    Oliver Strunk in <i>Source Readings in Music History, Volume V:
    The Romantic Era</i>.  New York, Norton.</p><div id="citediv_schumann_1946" class="flyoverdiv">Schumann, Robert.  1946.  <i>On Music and Musicians</i>.  Ed. Konrad
    Wolff; trans. Paul Rosenfeld.  New York: Pantheon Books.</div><p style="text-indent: -1em; margin-left: 1em; margin-top: 0em"><a name="schumann_1946"></a><span class='sans'>&mdash;&mdash;&mdash;&mdash;&mdash;</span>.  1946.  <i>On Music and Musicians</i>.  Ed. Konrad
    Wolff; trans. Paul Rosenfeld.  New York: Pantheon Books.</p>
	   
	<div style="height:24px;width:150px;background-color:#4c7381;float:left;text-align: center;vertical-align: middle;line-height: 24px;">
		&nbsp;&nbsp;&nbsp;
		<a style="color:white;" onmouseover="this.style.color='#0000ff';text-decoration:none" 
		onmouseout="this.style.color='white';" href="#Beginning">Return to beginning</a>
		&nbsp;&nbsp;&nbsp;
	</div><br><br>

		
<!-------------------------------- Footnotes List -------------------------------------------->

		
	<hr>
	
	<h3><a name="Footnotes">Footnotes</a></h3>
	
	<p><a name="FN1">1.</a> Nattiez (<a href="#nattiez_1990" id="citation_nattiez_1990_67dc9bfce4b3e">1990</a>, 19&ndash;28) identifies what he perceives to be a
contradiction in Eco's theory of codes&mdash;between a closed,
synchronic system of signification and an open diachronic process
of communication&mdash;that render it insufficient for
distinguishing the poietic and esthesic dimensions of semiosis, a
distinction that is the primary concern of <i>Music and Discourse</i>. 
(He classifies music analyses into six categories according to
how they engage these dimensions (139&ndash;143)).  I am not concerned
here with how meaning varies from one analysis to another, nor
with the tripartition, but with the more modest goals stated in
this paragraph, which I believe are accessible through the kind
of structural analysis of meaning that Eco describes. 
Nevertheless, from this restricted perspective I do pursue an
agenda suggested by Nattiez: to &ldquo;interrogate the different
methodologies practiced in music analysis&rdquo; (238), and so to
augment his brief characterizations of &ldquo;impressionistic&rdquo; (161),
&ldquo;formalistic&rdquo; (163), and graphic (165) modes of music analysis.<br><a href="#FN1REF">Return to text</a></p><p><a name="FN2">2.</a> <a href="#mazzola_1990" id="citation_mazzola_1990_67dc9bfce4b45">Mazzola 1990</a>, a recent mathematical music theory, explicitly
positions the integer model within Molino's semiotic
tripartition.<br><a href="#FN2REF">Return to text</a></p><p><a name="FN3">3.</a> On the other hand, the sign-function
correlating integers with pitch does not <i>preclude</i> another
semiotic system in which pitches denote integers.  A composer I
know remembers his bank-card identification digits by the tune
they denote.  But such reflexivity is not a necessary property of
the original semiosis.<br><a href="#FN3REF">Return to text</a></p><p><a name="FN4">4.</a> However, Schumann did seem to hear other short dances by
Schubert in nearly in same terms: &ldquo;Once, when I was playing a
Schubert march, the friend with whom I was playing gave the
following answer to my question whether he had not seen certain
very special forms before him: &lsquo;Yes! I felt I was in Seville more
than a hundred years ago, amid promenading Dons and Donnas, with
their trains, pointed shoes, daggers, etc.&rsquo;  Strange to say, our
visions were alike, even to the name of the city.&rdquo; (<a href="#schumann_1946" id="citation_schumann_1946_67dc9bfce4b49">Schumann 1946</a>, 182)<br><a href="#FN4REF">Return to text</a></p><p><a name="FN5">5.</a> The review as a whole aims to treat &ldquo;the four points of view
from which a work of musical art can be surveyed: that of form
(the whole, the separate movements, the section, the phrase);
that of musical composition (harmony, melody, texture, style,
workmanship); that of the special idea which the artist intended
to represent, and that of the spirit, which governs form, idea,
material&rdquo; (164).<br><a href="#FN5REF">Return to text</a></p><div id="fndiv1" class="flyoverdiv">Nattiez (<a href="#nattiez_1990" id="citation_nattiez_1990_67dc9bfce4b3e">1990</a>, 19&ndash;28) identifies what he perceives to be a
contradiction in Eco's theory of codes&mdash;between a closed,
synchronic system of signification and an open diachronic process
of communication&mdash;that render it insufficient for
distinguishing the poietic and esthesic dimensions of semiosis, a
distinction that is the primary concern of <i>Music and Discourse</i>. 
(He classifies music analyses into six categories according to
how they engage these dimensions (139&ndash;143)).  I am not concerned
here with how meaning varies from one analysis to another, nor
with the tripartition, but with the more modest goals stated in
this paragraph, which I believe are accessible through the kind
of structural analysis of meaning that Eco describes. 
Nevertheless, from this restricted perspective I do pursue an
agenda suggested by Nattiez: to &ldquo;interrogate the different
methodologies practiced in music analysis&rdquo; (238), and so to
augment his brief characterizations of &ldquo;impressionistic&rdquo; (161),
&ldquo;formalistic&rdquo; (163), and graphic (165) modes of music analysis.</div><div id="fndiv2" class="flyoverdiv"><a href="#mazzola_1990" id="citation_mazzola_1990_67dc9bfce4b45">Mazzola 1990</a>, a recent mathematical music theory, explicitly
positions the integer model within Molino's semiotic
tripartition.</div><div id="fndiv3" class="flyoverdiv">On the other hand, the sign-function
correlating integers with pitch does not <i>preclude</i> another
semiotic system in which pitches denote integers.  A composer I
know remembers his bank-card identification digits by the tune
they denote.  But such reflexivity is not a necessary property of
the original semiosis.</div><div id="fndiv4" class="flyoverdiv">However, Schumann did seem to hear other short dances by
Schubert in nearly in same terms: &ldquo;Once, when I was playing a
Schubert march, the friend with whom I was playing gave the
following answer to my question whether he had not seen certain
very special forms before him: &lsquo;Yes! I felt I was in Seville more
than a hundred years ago, amid promenading Dons and Donnas, with
their trains, pointed shoes, daggers, etc.&rsquo;  Strange to say, our
visions were alike, even to the name of the city.&rdquo; (<a href="#schumann_1946" id="citation_schumann_1946_67dc9bfce4b49">Schumann 1946</a>, 182)</div><div id="fndiv5" class="flyoverdiv">The review as a whole aims to treat &ldquo;the four points of view
from which a work of musical art can be surveyed: that of form
(the whole, the separate movements, the section, the phrase);
that of musical composition (harmony, melody, texture, style,
workmanship); that of the special idea which the artist intended
to represent, and that of the spirit, which governs form, idea,
material&rdquo; (164).</div>	
	   
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

