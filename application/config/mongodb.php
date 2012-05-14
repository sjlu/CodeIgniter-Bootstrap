


<!DOCTYPE html>
<html>
  <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# githubog: http://ogp.me/ns/fb/githubog#">
    <meta charset='utf-8'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>codeigniter-mongodb-library/config/mongodb.php at v2 · alexbilbie/codeigniter-mongodb-library · GitHub</title>
    <link rel="search" type="application/opensearchdescription+xml" href="/opensearch.xml" title="GitHub" />
    <link rel="fluid-icon" href="https://github.com/fluidicon.png" title="GitHub" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />

    
    

    <meta content="authenticity_token" name="csrf-param" />
<meta content="Gcn7ld5z+aSypGqrp5sgT5f3hL6D1fFT0m3tSzLNXQM=" name="csrf-token" />

    <link href="https://a248.e.akamai.net/assets.github.com/stylesheets/bundles/github-f9e9af6c222638865ece5a631cda303e46d2ffd1.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="https://a248.e.akamai.net/assets.github.com/stylesheets/bundles/github2-c1921b914a1a5c9fd63f1f197c5742bcc5500740.css" media="screen" rel="stylesheet" type="text/css" />
    
    
    

    <script src="https://a248.e.akamai.net/assets.github.com/javascripts/bundles/frameworks-31b6b84bca1e7d3f3907f63a4dd7f9bbda3a0eda.js" type="text/javascript"></script>
    
    <script defer="defer" src="https://a248.e.akamai.net/assets.github.com/javascripts/bundles/github-99337a19d9651b20f8dabf3f67bb41e704d052b7.js" type="text/javascript"></script>
    
    

      <link rel='permalink' href='/alexbilbie/codeigniter-mongodb-library/blob/b94c3cd87b93060c94bfe180de3cc92648ffdc9d/config/mongodb.php'>
    <meta property="og:title" content="codeigniter-mongodb-library"/>
    <meta property="og:type" content="githubog:gitrepository"/>
    <meta property="og:url" content="https://github.com/alexbilbie/codeigniter-mongodb-library"/>
    <meta property="og:image" content="https://a248.e.akamai.net/assets.github.com/images/gravatars/gravatar-140.png?1329275859"/>
    <meta property="og:site_name" content="GitHub"/>
    <meta property="og:description" content="codeigniter-mongodb-library - NEW VERSION UNDER DEVELOPMENT - SEE V2 BRANCH. CodeIgniter library for interfacing with MongoDB"/>

    <meta name="description" content="codeigniter-mongodb-library - NEW VERSION UNDER DEVELOPMENT - SEE V2 BRANCH. CodeIgniter library for interfacing with MongoDB" />

  <link href="https://github.com/alexbilbie/codeigniter-mongodb-library/commits/v2.atom" rel="alternate" title="Recent Commits to codeigniter-mongodb-library:v2" type="application/atom+xml" />

  </head>


  <body class="logged_out page-blob  vis-public env-production " data-blob-contribs-enabled="yes">
    <div id="wrapper">

    
    
    

      <div id="header" class="true clearfix">
        <div class="container clearfix">
          <a class="site-logo" href="https://github.com">
            <!--[if IE]>
            <img alt="GitHub" class="github-logo" src="https://a248.e.akamai.net/assets.github.com/images/modules/header/logov7.png?1323882717" />
            <img alt="GitHub" class="github-logo-hover" src="https://a248.e.akamai.net/assets.github.com/images/modules/header/logov7-hover.png?1324325376" />
            <![endif]-->
            <img alt="GitHub" class="github-logo-4x" height="30" src="https://a248.e.akamai.net/assets.github.com/images/modules/header/logov7@4x.png?1323882717" />
            <img alt="GitHub" class="github-logo-4x-hover" height="30" src="https://a248.e.akamai.net/assets.github.com/images/modules/header/logov7@4x-hover.png?1324325376" />
          </a>

                  <!--
      make sure to use fully qualified URLs here since this nav
      is used on error pages on other domains
    -->
    <ul class="top-nav logged_out">
        <li class="pricing"><a href="https://github.com/plans">Signup and Pricing</a></li>
        <li class="explore"><a href="https://github.com/explore">Explore GitHub</a></li>
      <li class="features"><a href="https://github.com/features">Features</a></li>
        <li class="blog"><a href="https://github.com/blog">Blog</a></li>
      <li class="login"><a href="https://github.com/login?return_to=%2Falexbilbie%2Fcodeigniter-mongodb-library%2Fblob%2Fv2%2Fconfig%2Fmongodb.php">Login</a></li>
    </ul>



          
        </div>
      </div>

      

            <div class="site hfeed" itemscope itemtype="http://schema.org/WebPage">
      <div class="container hentry">
        <div class="pagehead repohead instapaper_ignore readability-menu">
        <div class="title-actions-bar">
          



              <ul class="pagehead-actions">



          <li>
            <a href="/login?return_to=%2Falexbilbie%2Fcodeigniter-mongodb-library" class="minibutton btn-i-type-i-switcher switcher count btn-watches js-toggler-target watch-button entice tooltipped leftwards" title="You must be logged in to use this feature" rel="nofollow"><span><span class="icon"></span><i>166</i> Watch</span></a>
          </li>
          <li>
            <a href="/login?return_to=%2Falexbilbie%2Fcodeigniter-mongodb-library" class="minibutton btn-i-type-i-switcher switcher count btn-forks js-toggler-target fork-button entice tooltipped leftwards"  title="You must be logged in to use this feature" rel="nofollow"><span><span class="icon"></span><i>44</i> Fork</span></a>
          </li>

    </ul>

          <h1 itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="entry-title">
            <span class="repo-label"><span class="public">public</span></span>
            <span class="mega-icon public-repo"></span>
            <span class="author vcard">
<a href="/alexbilbie" class="url fn" itemprop="url" rel="author">              <span itemprop="title">alexbilbie</span>
              </a></span> /
            <strong><a href="/alexbilbie/codeigniter-mongodb-library" class="js-current-repository">codeigniter-mongodb-library</a></strong>
          </h1>
        </div>

          

  <ul class="tabs">
    <li><a href="/alexbilbie/codeigniter-mongodb-library/tree/v2" class="selected" highlight="repo_sourcerepo_downloadsrepo_commitsrepo_tagsrepo_branches">Code</a></li>
    <li><a href="/alexbilbie/codeigniter-mongodb-library/network" highlight="repo_network">Network</a>
    <li><a href="/alexbilbie/codeigniter-mongodb-library/pulls" highlight="repo_pulls">Pull Requests <span class='counter'>1</span></a></li>

      <li><a href="/alexbilbie/codeigniter-mongodb-library/issues" highlight="repo_issues">Issues <span class='counter'>7</span></a></li>


    <li><a href="/alexbilbie/codeigniter-mongodb-library/graphs" highlight="repo_graphsrepo_contributors">Graphs</a></li>

  </ul>
 
<div class="frame frame-center tree-finder" style="display:none"
      data-tree-list-url="/alexbilbie/codeigniter-mongodb-library/tree-list/b94c3cd87b93060c94bfe180de3cc92648ffdc9d"
      data-blob-url-prefix="/alexbilbie/codeigniter-mongodb-library/blob/b94c3cd87b93060c94bfe180de3cc92648ffdc9d"
    >

  <div class="breadcrumb">
    <span class="bold"><a href="/alexbilbie/codeigniter-mongodb-library">codeigniter-mongodb-library</a></span> /
    <input class="tree-finder-input js-navigation-enable" type="text" name="query" autocomplete="off" spellcheck="false">
  </div>

    <div class="octotip">
      <p>
        <a href="/alexbilbie/codeigniter-mongodb-library/dismiss-tree-finder-help" class="dismiss js-dismiss-tree-list-help" title="Hide this notice forever" rel="nofollow">Dismiss</a>
        <span class="bold">Octotip:</span> You've activated the <em>file finder</em>
        by pressing <span class="kbd">t</span> Start typing to filter the
        file list. Use <span class="kbd badmono">↑</span> and
        <span class="kbd badmono">↓</span> to navigate,
        <span class="kbd">enter</span> to view files.
      </p>
    </div>

  <table class="tree-browser" cellpadding="0" cellspacing="0">
    <tr class="js-header"><th>&nbsp;</th><th>name</th></tr>
    <tr class="js-no-results no-results" style="display: none">
      <th colspan="2">No matching files</th>
    </tr>
    <tbody class="js-results-list js-navigation-container">
    </tbody>
  </table>
</div>

<div id="jump-to-line" style="display:none">
  <h2>Jump to Line</h2>
  <form accept-charset="UTF-8">
    <input class="textfield" type="text">
    <div class="full-button">
      <button type="submit" class="classy">
        <span>Go</span>
      </button>
    </div>
  </form>
</div>


<div class="subnav-bar">

  <ul class="actions subnav">
    <li><a href="/alexbilbie/codeigniter-mongodb-library/tags" class="" highlight="repo_tags">Tags <span class="counter">5</span></a></li>
    <li><a href="/alexbilbie/codeigniter-mongodb-library/downloads" class="blank downloads-blank" highlight="repo_downloads">Downloads <span class="counter">0</span></a></li>
    
  </ul>

  <ul class="scope">
    <li class="switcher">

      <div class="context-menu-container js-menu-container js-context-menu">
        <a href="#"
           class="minibutton bigger switcher js-menu-target js-commitish-button btn-branch repo-tree"
           data-hotkey="w"
           data-master-branch="master"
           data-ref="v2">
          <span><span class="icon"></span><i>branch:</i> v2</span>
        </a>

        <div class="context-pane commitish-context js-menu-content">
          <a href="javascript:;" class="close js-menu-close"><span class="mini-icon remove-close"></span></a>
          <div class="context-title">Switch Branches/Tags</div>
          <div class="context-body pane-selector commitish-selector js-navigation-container">
            <div class="filterbar">
              <input type="text" id="context-commitish-filter-field" class="js-navigation-enable" placeholder="Filter branches/tags" data-filterable />

              <ul class="tabs">
                <li><a href="#" data-filter="branches" class="selected">Branches</a></li>
                <li><a href="#" data-filter="tags">Tags</a></li>
              </ul>
            </div>

            <div class="js-filter-tab js-filter-branches" data-filterable-for="context-commitish-filter-field">
              <div class="no-results js-not-filterable">Nothing to show</div>
                <div class="commitish-item branch-commitish selector-item js-navigation-item js-navigation-target">
                  <h4>
                      <a href="/alexbilbie/codeigniter-mongodb-library/blob/master/config/mongodb.php" class="js-navigation-open" data-name="master" rel="nofollow">master</a>
                  </h4>
                </div>
                <div class="commitish-item branch-commitish selector-item js-navigation-item js-navigation-target">
                  <h4>
                      <a href="/alexbilbie/codeigniter-mongodb-library/blob/v2/config/mongodb.php" class="js-navigation-open" data-name="v2" rel="nofollow">v2</a>
                  </h4>
                </div>
                <div class="commitish-item branch-commitish selector-item js-navigation-item js-navigation-target">
                  <h4>
                      <a href="/alexbilbie/codeigniter-mongodb-library/blob/v2-groups/config/mongodb.php" class="js-navigation-open" data-name="v2-groups" rel="nofollow">v2-groups</a>
                  </h4>
                </div>
            </div>

            <div class="js-filter-tab js-filter-tags" style="display:none" data-filterable-for="context-commitish-filter-field">
              <div class="no-results js-not-filterable">Nothing to show</div>
                <div class="commitish-item tag-commitish selector-item js-navigation-item js-navigation-target">
                  <h4>
                      <a href="/alexbilbie/codeigniter-mongodb-library/blob/0.5.2/config/mongodb.php" class="js-navigation-open" data-name="0.5.2" rel="nofollow">0.5.2</a>
                  </h4>
                </div>
                <div class="commitish-item tag-commitish selector-item js-navigation-item js-navigation-target">
                  <h4>
                      <a href="/alexbilbie/codeigniter-mongodb-library/blob/0.5.1/config/mongodb.php" class="js-navigation-open" data-name="0.5.1" rel="nofollow">0.5.1</a>
                  </h4>
                </div>
                <div class="commitish-item tag-commitish selector-item js-navigation-item js-navigation-target">
                  <h4>
                      <a href="/alexbilbie/codeigniter-mongodb-library/blob/0.5/config/mongodb.php" class="js-navigation-open" data-name="0.5" rel="nofollow">0.5</a>
                  </h4>
                </div>
                <div class="commitish-item tag-commitish selector-item js-navigation-item js-navigation-target">
                  <h4>
                      <a href="/alexbilbie/codeigniter-mongodb-library/blob/0.4.8/config/mongodb.php" class="js-navigation-open" data-name="0.4.8" rel="nofollow">0.4.8</a>
                  </h4>
                </div>
                <div class="commitish-item tag-commitish selector-item js-navigation-item js-navigation-target">
                  <h4>
                      <a href="/alexbilbie/codeigniter-mongodb-library/blob/0.4.7/config/mongodb.php" class="js-navigation-open" data-name="0.4.7" rel="nofollow">0.4.7</a>
                  </h4>
                </div>
            </div>
          </div>
        </div><!-- /.commitish-context-context -->
      </div>

    </li>
  </ul>

  <ul class="subnav with-scope">

    <li><a href="/alexbilbie/codeigniter-mongodb-library/tree/v2" class="selected" highlight="repo_source">Files</a></li>
    <li><a href="/alexbilbie/codeigniter-mongodb-library/commits/v2" highlight="repo_commits">Commits</a></li>
    <li><a href="/alexbilbie/codeigniter-mongodb-library/branches" class="" highlight="repo_branches" rel="nofollow">Branches <span class="counter">3</span></a></li>
  </ul>

</div>

  
  
  


          

        </div><!-- /.repohead -->

        





<!-- block_view_fragment_key: views8/v8/blob:v21:d7749f9b980bc652d413070563ac59ed -->
  <div id="slider">

    <div class="breadcrumb" data-path="config/mongodb.php/">
      <b itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="/alexbilbie/codeigniter-mongodb-library/tree/b94c3cd87b93060c94bfe180de3cc92648ffdc9d" class="js-rewrite-sha" itemprop="url"><span itemprop="title">codeigniter-mongodb-library</span></a></b> / <span itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb"><a href="/alexbilbie/codeigniter-mongodb-library/tree/b94c3cd87b93060c94bfe180de3cc92648ffdc9d/config" class="js-rewrite-sha" itemscope="url"><span itemprop="title">config</span></a></span> / <strong class="final-path">mongodb.php</strong> <span class="js-clippy mini-icon clippy " data-clipboard-text="config/mongodb.php" data-copied-hint="copied!" data-copy-hint="copy to clipboard"></span>
    </div>


      <div class="commit file-history-tease" data-path="config/mongodb.php/">
        <img class="main-avatar" height="24" src="https://secure.gravatar.com/avatar/74f280e194c5ccf3ebe7cef685221020?s=140&amp;d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-140.png" width="24" />
        <span class="author"><a href="/ckd">ckd</a></span>
        <time class="js-relative-date" datetime="2012-03-14T16:59:20-07:00" title="2012-03-14 16:59:20">March 14, 2012</time>
        <div class="commit-title">
            <a href="/alexbilbie/codeigniter-mongodb-library/commit/a3a01131a7f4e797ca0e0ab093d2dcc524235e60" class="message">renamed replica_set for consistency</a>
        </div>

        <div class="participation">
          <p class="quickstat"><a href="#blob_contributors_box" rel="facebox"><strong>3</strong> contributors</a></p>
              <a class="avatar tooltipped downwards" title="alexbilbie" href="/alexbilbie/codeigniter-mongodb-library/commits/v2/config/mongodb.php?author=alexbilbie"><img height="20" src="https://secure.gravatar.com/avatar/9e8b12e039758ff9446de8676dc5e6a9?s=140&amp;d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-140.png" width="20" /></a>
    <a class="avatar tooltipped downwards" title="ckd" href="/alexbilbie/codeigniter-mongodb-library/commits/v2/config/mongodb.php?author=ckd"><img height="20" src="https://secure.gravatar.com/avatar/74f280e194c5ccf3ebe7cef685221020?s=140&amp;d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-140.png" width="20" /></a>
    <a class="avatar tooltipped downwards" title="jacksonj04" href="/alexbilbie/codeigniter-mongodb-library/commits/v2/config/mongodb.php?author=jacksonj04"><img height="20" src="https://secure.gravatar.com/avatar/c7f3b4756d808ef0e2548bd0965ac225?s=140&amp;d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-140.png" width="20" /></a>


        </div>
        <div id="blob_contributors_box" style="display:none">
          <h2>Users on GitHub who have contributed to this file</h2>
          <ul class="facebox-user-list">
            <li>
              <img height="24" src="https://secure.gravatar.com/avatar/9e8b12e039758ff9446de8676dc5e6a9?s=140&amp;d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-140.png" width="24" />
              <a href="/alexbilbie">alexbilbie</a>
            </li>
            <li>
              <img height="24" src="https://secure.gravatar.com/avatar/74f280e194c5ccf3ebe7cef685221020?s=140&amp;d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-140.png" width="24" />
              <a href="/ckd">ckd</a>
            </li>
            <li>
              <img height="24" src="https://secure.gravatar.com/avatar/c7f3b4756d808ef0e2548bd0965ac225?s=140&amp;d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-140.png" width="24" />
              <a href="/jacksonj04">jacksonj04</a>
            </li>
          </ul>
        </div>
      </div>

    <div class="frames">
      <div class="frame frame-center" data-path="config/mongodb.php/" data-permalink-url="/alexbilbie/codeigniter-mongodb-library/blob/b94c3cd87b93060c94bfe180de3cc92648ffdc9d/config/mongodb.php" data-title="codeigniter-mongodb-library/config/mongodb.php at v2 · alexbilbie/codeigniter-mongodb-library · GitHub" data-type="blob">

        <div id="files" class="bubble">
          <div class="file">
            <div class="meta">
              <div class="info">
                <span class="icon"><b class="mini-icon text-file"></b></span>
                <span class="mode" title="File Mode">100644</span>
                  <span>28 lines (26 sloc)</span>
                <span>1.814 kb</span>
              </div>
              <ul class="button-group actions">
                  <li>
                    <a class="grouped-button file-edit-link minibutton bigger lighter js-rewrite-sha" href="/alexbilbie/codeigniter-mongodb-library/edit/b94c3cd87b93060c94bfe180de3cc92648ffdc9d/config/mongodb.php" data-method="post" rel="nofollow" data-hotkey="e"><span>Edit this file</span></a>
                  </li>

                <li>
                  <a href="/alexbilbie/codeigniter-mongodb-library/raw/v2/config/mongodb.php" class="minibutton btn-raw grouped-button bigger lighter" id="raw-url"><span><span class="icon"></span>Raw</span></a>
                </li>
                  <li>
                    <a href="/alexbilbie/codeigniter-mongodb-library/blame/v2/config/mongodb.php" class="minibutton btn-blame grouped-button bigger lighter"><span><span class="icon"></span>Blame</span></a>
                  </li>
                <li>
                  <a href="/alexbilbie/codeigniter-mongodb-library/commits/v2/config/mongodb.php" class="minibutton btn-history grouped-button bigger lighter" rel="nofollow"><span><span class="icon"></span>History</span></a>
                </li>
              </ul>
            </div>
              <div class="data type-php">
      <table cellpadding="0" cellspacing="0" class="lines">
        <tr>
          <td>
            <pre class="line_numbers"><span id="L1" rel="#L1">1</span>
<span id="L2" rel="#L2">2</span>
<span id="L3" rel="#L3">3</span>
<span id="L4" rel="#L4">4</span>
<span id="L5" rel="#L5">5</span>
<span id="L6" rel="#L6">6</span>
<span id="L7" rel="#L7">7</span>
<span id="L8" rel="#L8">8</span>
<span id="L9" rel="#L9">9</span>
<span id="L10" rel="#L10">10</span>
<span id="L11" rel="#L11">11</span>
<span id="L12" rel="#L12">12</span>
<span id="L13" rel="#L13">13</span>
<span id="L14" rel="#L14">14</span>
<span id="L15" rel="#L15">15</span>
<span id="L16" rel="#L16">16</span>
<span id="L17" rel="#L17">17</span>
<span id="L18" rel="#L18">18</span>
<span id="L19" rel="#L19">19</span>
<span id="L20" rel="#L20">20</span>
<span id="L21" rel="#L21">21</span>
<span id="L22" rel="#L22">22</span>
<span id="L23" rel="#L23">23</span>
<span id="L24" rel="#L24">24</span>
<span id="L25" rel="#L25">25</span>
<span id="L26" rel="#L26">26</span>
<span id="L27" rel="#L27">27</span>
<span id="L28" rel="#L28">28</span>
</pre>
          </td>
          <td width="100%">
                <div class="highlight"><pre><div class='line' id='LC1'><span class="cp">&lt;?php</span>  <span class="k">if</span> <span class="p">(</span> <span class="o">!</span> <span class="nb">defined</span><span class="p">(</span><span class="s1">&#39;BASEPATH&#39;</span><span class="p">))</span> <span class="k">exit</span><span class="p">(</span><span class="s1">&#39;No direct script access allowed&#39;</span><span class="p">);</span></div><div class='line' id='LC2'><br/></div><div class='line' id='LC3'><span class="cm">/* -------------------------------------------------------------------</span></div><div class='line' id='LC4'><span class="cm"> * EXPLANATION OF VARIABLES</span></div><div class='line' id='LC5'><span class="cm"> * -------------------------------------------------------------------</span></div><div class='line' id='LC6'><span class="cm"> *</span></div><div class='line' id='LC7'><span class="cm"> * [&#39;mongo_hostbase&#39;] The hostname (and port number) of your mongod or mongos instances. Comma delimited list if connecting to a replica set.</span></div><div class='line' id='LC8'><span class="cm"> * [&#39;mongo_database&#39;] The name of the database you want to connect to</span></div><div class='line' id='LC9'><span class="cm"> * [&#39;mongo_username&#39;] The username used to connect to the database (if auth mode is enabled)</span></div><div class='line' id='LC10'><span class="cm"> * [&#39;mongo_password&#39;] The password used to connect to the database (if auth mode is enabled)</span></div><div class='line' id='LC11'><span class="cm"> * [&#39;mongo_persist&#39;]  Persist the connection. Highly recommend you don&#39;t set to FALSE</span></div><div class='line' id='LC12'><span class="cm"> * [&#39;mongo_persist_key&#39;] The persistant connection key</span></div><div class='line' id='LC13'><span class="cm"> * [&#39;mongo_replica_set&#39;] If connecting to a replica set, the name of the set. FALSE if not.</span></div><div class='line' id='LC14'><span class="cm"> * [&#39;mongo_query_safety&#39;] Safety level of write queries. &quot;safe&quot; = committed in memory, &quot;fsync&quot; = committed to harddisk</span></div><div class='line' id='LC15'><span class="cm"> * [&#39;mongo_suppress_connect_error&#39;] If the driver can&#39;t connect by default it will throw an error which dislays the username and password used to connect. Set to TRUE to hide these details.</span></div><div class='line' id='LC16'><span class="cm"> * [&#39;mongo_host_db_flag&#39;]   If running in auth mode and the user does not have global read/write then set this to true</span></div><div class='line' id='LC17'><span class="cm"> */</span></div><div class='line' id='LC18'><br/></div><div class='line' id='LC19'><span class="nv">$config</span><span class="p">[</span><span class="s1">&#39;default&#39;</span><span class="p">][</span><span class="s1">&#39;mongo_hostbase&#39;</span><span class="p">]</span> <span class="o">=</span> <span class="s1">&#39;localhost:27017&#39;</span><span class="p">;</span></div><div class='line' id='LC20'><span class="nv">$config</span><span class="p">[</span><span class="s1">&#39;default&#39;</span><span class="p">][</span><span class="s1">&#39;mongo_database&#39;</span><span class="p">]</span> <span class="o">=</span> <span class="s1">&#39;&#39;</span><span class="p">;</span></div><div class='line' id='LC21'><span class="nv">$config</span><span class="p">[</span><span class="s1">&#39;default&#39;</span><span class="p">][</span><span class="s1">&#39;mongo_username&#39;</span><span class="p">]</span> <span class="o">=</span> <span class="s1">&#39;&#39;</span><span class="p">;</span></div><div class='line' id='LC22'><span class="nv">$config</span><span class="p">[</span><span class="s1">&#39;default&#39;</span><span class="p">][</span><span class="s1">&#39;mongo_password&#39;</span><span class="p">]</span> <span class="o">=</span> <span class="s1">&#39;&#39;</span><span class="p">;</span></div><div class='line' id='LC23'><span class="nv">$config</span><span class="p">[</span><span class="s1">&#39;default&#39;</span><span class="p">][</span><span class="s1">&#39;mongo_persist&#39;</span><span class="p">]</span>  <span class="o">=</span> <span class="k">TRUE</span><span class="p">;</span></div><div class='line' id='LC24'><span class="nv">$config</span><span class="p">[</span><span class="s1">&#39;default&#39;</span><span class="p">][</span><span class="s1">&#39;mongo_persist_key&#39;</span><span class="p">]</span>	 <span class="o">=</span> <span class="s1">&#39;ci_persist&#39;</span><span class="p">;</span></div><div class='line' id='LC25'><span class="nv">$config</span><span class="p">[</span><span class="s1">&#39;default&#39;</span><span class="p">][</span><span class="s1">&#39;mongo_replica_set&#39;</span><span class="p">]</span>  <span class="o">=</span> <span class="k">FALSE</span><span class="p">;</span></div><div class='line' id='LC26'><span class="nv">$config</span><span class="p">[</span><span class="s1">&#39;default&#39;</span><span class="p">][</span><span class="s1">&#39;mongo_query_safety&#39;</span><span class="p">]</span> <span class="o">=</span> <span class="s1">&#39;safe&#39;</span><span class="p">;</span></div><div class='line' id='LC27'><span class="nv">$config</span><span class="p">[</span><span class="s1">&#39;default&#39;</span><span class="p">][</span><span class="s1">&#39;mongo_suppress_connect_error&#39;</span><span class="p">]</span> <span class="o">=</span> <span class="k">TRUE</span><span class="p">;</span></div><div class='line' id='LC28'><span class="nv">$config</span><span class="p">[</span><span class="s1">&#39;default&#39;</span><span class="p">][</span><span class="s1">&#39;mongo_host_db_flag&#39;</span><span class="p">]</span>   <span class="o">=</span> <span class="k">FALSE</span><span class="p">;</span></div></pre></div>
          </td>
        </tr>
      </table>
  </div>

          </div>
        </div>
      </div>
    </div>

  </div>

<div class="frame frame-loading large-loading-area" style="display:none;" data-tree-list-url="/alexbilbie/codeigniter-mongodb-library/tree-list/b94c3cd87b93060c94bfe180de3cc92648ffdc9d" data-blob-url-prefix="/alexbilbie/codeigniter-mongodb-library/blob/b94c3cd87b93060c94bfe180de3cc92648ffdc9d">
  <img src="https://a248.e.akamai.net/assets.github.com/images/spinners/octocat-spinner-64.gif?1329872007" height="64" width="64">
</div>

      </div>
      <div class="context-overlay"></div>
    </div>

      <div id="footer-push"></div><!-- hack for sticky footer -->
    </div><!-- end of wrapper - hack for sticky footer -->

      <!-- footer -->
      <div id="footer" >
        
  <div class="upper_footer">
     <div class="container clearfix">

       <!--[if IE]><h4 id="blacktocat_ie">GitHub Links</h4><![endif]-->
       <![if !IE]><h4 id="blacktocat">GitHub Links</h4><![endif]>

       <ul class="footer_nav">
         <h4>GitHub</h4>
         <li><a href="https://github.com/about">About</a></li>
         <li><a href="https://github.com/blog">Blog</a></li>
         <li><a href="https://github.com/features">Features</a></li>
         <li><a href="https://github.com/contact">Contact &amp; Support</a></li>
         <li><a href="https://github.com/training">Training</a></li>
         <li><a href="http://enterprise.github.com/">GitHub Enterprise</a></li>
         <li><a href="http://status.github.com/">Site Status</a></li>
       </ul>

       <ul class="footer_nav">
         <h4>Tools</h4>
         <li><a href="http://get.gaug.es/">Gauges: Analyze web traffic</a></li>
         <li><a href="http://speakerdeck.com">Speaker Deck: Presentations</a></li>
         <li><a href="https://gist.github.com">Gist: Code snippets</a></li>
         <li><a href="http://mac.github.com/">GitHub for Mac</a></li>
         <li><a href="http://mobile.github.com/">Issues for iPhone</a></li>
         <li><a href="http://jobs.github.com/">Job Board</a></li>
       </ul>

       <ul class="footer_nav">
         <h4>Extras</h4>
         <li><a href="http://shop.github.com/">GitHub Shop</a></li>
         <li><a href="http://octodex.github.com/">The Octodex</a></li>
       </ul>

       <ul class="footer_nav">
         <h4>Documentation</h4>
         <li><a href="http://help.github.com/">GitHub Help</a></li>
         <li><a href="http://developer.github.com/">Developer API</a></li>
         <li><a href="http://github.github.com/github-flavored-markdown/">GitHub Flavored Markdown</a></li>
         <li><a href="http://pages.github.com/">GitHub Pages</a></li>
       </ul>

     </div><!-- /.site -->
  </div><!-- /.upper_footer -->

<div class="lower_footer">
  <div class="container clearfix">
    <!--[if IE]><div id="legal_ie"><![endif]-->
    <![if !IE]><div id="legal"><![endif]>
      <ul>
          <li><a href="https://github.com/site/terms">Terms of Service</a></li>
          <li><a href="https://github.com/site/privacy">Privacy</a></li>
          <li><a href="https://github.com/security">Security</a></li>
      </ul>

      <p>&copy; 2012 <span title="0.06661s from fe11.rs.github.com">GitHub</span> Inc. All rights reserved.</p>
    </div><!-- /#legal or /#legal_ie-->

      <div class="sponsor">
        <a href="http://www.rackspace.com" class="logo">
          <img alt="Dedicated Server" height="36" src="https://a248.e.akamai.net/assets.github.com/images/modules/footer/rackspaces_logo.png?1329521039" width="38" />
        </a>
        Powered by the <a href="http://www.rackspace.com ">Dedicated
        Servers</a> and<br/> <a href="http://www.rackspacecloud.com">Cloud
        Computing</a> of Rackspace Hosting<span>&reg;</span>
      </div>
  </div><!-- /.site -->
</div><!-- /.lower_footer -->

      </div><!-- /#footer -->

    

<div id="keyboard_shortcuts_pane" class="instapaper_ignore readability-extra" style="display:none">
  <h2>Keyboard Shortcuts <small><a href="#" class="js-see-all-keyboard-shortcuts">(see all)</a></small></h2>

  <div class="columns threecols">
    <div class="column first">
      <h3>Site wide shortcuts</h3>
      <dl class="keyboard-mappings">
        <dt>s</dt>
        <dd>Focus site search</dd>
      </dl>
      <dl class="keyboard-mappings">
        <dt>?</dt>
        <dd>Bring up this help dialog</dd>
      </dl>
    </div><!-- /.column.first -->

    <div class="column middle" style='display:none'>
      <h3>Commit list</h3>
      <dl class="keyboard-mappings">
        <dt>j</dt>
        <dd>Move selection down</dd>
      </dl>
      <dl class="keyboard-mappings">
        <dt>k</dt>
        <dd>Move selection up</dd>
      </dl>
      <dl class="keyboard-mappings">
        <dt>c <em>or</em> o <em>or</em> enter</dt>
        <dd>Open commit</dd>
      </dl>
      <dl class="keyboard-mappings">
        <dt>y</dt>
        <dd>Expand URL to its canonical form</dd>
      </dl>
    </div><!-- /.column.first -->

    <div class="column last" style='display:none'>
      <h3>Pull request list</h3>
      <dl class="keyboard-mappings">
        <dt>j</dt>
        <dd>Move selection down</dd>
      </dl>
      <dl class="keyboard-mappings">
        <dt>k</dt>
        <dd>Move selection up</dd>
      </dl>
      <dl class="keyboard-mappings">
        <dt>o <em>or</em> enter</dt>
        <dd>Open issue</dd>
      </dl>
      <dl class="keyboard-mappings">
        <dt><span class="platform-mac">⌘</span><span class="platform-other">ctrl</span> <em>+</em> enter</dt>
        <dd>Submit comment</dd>
      </dl>
    </div><!-- /.columns.last -->

  </div><!-- /.columns.equacols -->

  <div style='display:none'>
    <div class="rule"></div>

    <h3>Issues</h3>

    <div class="columns threecols">
      <div class="column first">
        <dl class="keyboard-mappings">
          <dt>j</dt>
          <dd>Move selection down</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>k</dt>
          <dd>Move selection up</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>x</dt>
          <dd>Toggle selection</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>o <em>or</em> enter</dt>
          <dd>Open issue</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt><span class="platform-mac">⌘</span><span class="platform-other">ctrl</span> <em>+</em> enter</dt>
          <dd>Submit comment</dd>
        </dl>
      </div><!-- /.column.first -->
      <div class="column last">
        <dl class="keyboard-mappings">
          <dt>c</dt>
          <dd>Create issue</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>l</dt>
          <dd>Create label</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>i</dt>
          <dd>Back to inbox</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>u</dt>
          <dd>Back to issues</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>/</dt>
          <dd>Focus issues search</dd>
        </dl>
      </div>
    </div>
  </div>

  <div style='display:none'>
    <div class="rule"></div>

    <h3>Issues Dashboard</h3>

    <div class="columns threecols">
      <div class="column first">
        <dl class="keyboard-mappings">
          <dt>j</dt>
          <dd>Move selection down</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>k</dt>
          <dd>Move selection up</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>o <em>or</em> enter</dt>
          <dd>Open issue</dd>
        </dl>
      </div><!-- /.column.first -->
    </div>
  </div>

  <div style='display:none'>
    <div class="rule"></div>

    <h3>Network Graph</h3>
    <div class="columns equacols">
      <div class="column first">
        <dl class="keyboard-mappings">
          <dt><span class="badmono">←</span> <em>or</em> h</dt>
          <dd>Scroll left</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt><span class="badmono">→</span> <em>or</em> l</dt>
          <dd>Scroll right</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt><span class="badmono">↑</span> <em>or</em> k</dt>
          <dd>Scroll up</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt><span class="badmono">↓</span> <em>or</em> j</dt>
          <dd>Scroll down</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>t</dt>
          <dd>Toggle visibility of head labels</dd>
        </dl>
      </div><!-- /.column.first -->
      <div class="column last">
        <dl class="keyboard-mappings">
          <dt>shift <span class="badmono">←</span> <em>or</em> shift h</dt>
          <dd>Scroll all the way left</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>shift <span class="badmono">→</span> <em>or</em> shift l</dt>
          <dd>Scroll all the way right</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>shift <span class="badmono">↑</span> <em>or</em> shift k</dt>
          <dd>Scroll all the way up</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>shift <span class="badmono">↓</span> <em>or</em> shift j</dt>
          <dd>Scroll all the way down</dd>
        </dl>
      </div><!-- /.column.last -->
    </div>
  </div>

  <div >
    <div class="rule"></div>
    <div class="columns threecols">
      <div class="column first" >
        <h3>Source Code Browsing</h3>
        <dl class="keyboard-mappings">
          <dt>t</dt>
          <dd>Activates the file finder</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>l</dt>
          <dd>Jump to line</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>w</dt>
          <dd>Switch branch/tag</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>y</dt>
          <dd>Expand URL to its canonical form</dd>
        </dl>
      </div>
    </div>
  </div>

  <div style='display:none'>
    <div class="rule"></div>
    <div class="columns threecols">
      <div class="column first">
        <h3>Browsing Commits</h3>
        <dl class="keyboard-mappings">
          <dt><span class="platform-mac">⌘</span><span class="platform-other">ctrl</span> <em>+</em> enter</dt>
          <dd>Submit comment</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>escape</dt>
          <dd>Close form</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>p</dt>
          <dd>Parent commit</dd>
        </dl>
        <dl class="keyboard-mappings">
          <dt>o</dt>
          <dd>Other parent commit</dd>
        </dl>
      </div>
    </div>
  </div>
</div>

    <div id="markdown-help" class="instapaper_ignore readability-extra">
  <h2>Markdown Cheat Sheet</h2>

  <div class="cheatsheet-content">

  <div class="mod">
    <div class="col">
      <h3>Format Text</h3>
      <p>Headers</p>
      <pre>
# This is an &lt;h1&gt; tag
## This is an &lt;h2&gt; tag
###### This is an &lt;h6&gt; tag</pre>
     <p>Text styles</p>
     <pre>
*This text will be italic*
_This will also be italic_
**This text will be bold**
__This will also be bold__

*You **can** combine them*
</pre>
    </div>
    <div class="col">
      <h3>Lists</h3>
      <p>Unordered</p>
      <pre>
* Item 1
* Item 2
  * Item 2a
  * Item 2b</pre>
     <p>Ordered</p>
     <pre>
1. Item 1
2. Item 2
3. Item 3
   * Item 3a
   * Item 3b</pre>
    </div>
    <div class="col">
      <h3>Miscellaneous</h3>
      <p>Images</p>
      <pre>
![GitHub Logo](/images/logo.png)
Format: ![Alt Text](url)
</pre>
     <p>Links</p>
     <pre>
http://github.com - automatic!
[GitHub](http://github.com)</pre>
<p>Blockquotes</p>
     <pre>
As Kanye West said:

> We're living the future so
> the present is our past.
</pre>
    </div>
  </div>
  <div class="rule"></div>

  <h3>Code Examples in Markdown</h3>
  <div class="col">
      <p>Syntax highlighting with <a href="http://github.github.com/github-flavored-markdown/" title="GitHub Flavored Markdown" target="_blank">GFM</a></p>
      <pre>
```javascript
function fancyAlert(arg) {
  if(arg) {
    $.facebox({div:'#foo'})
  }
}
```</pre>
    </div>
    <div class="col">
      <p>Or, indent your code 4 spaces</p>
      <pre>
Here is a Python code example
without syntax highlighting:

    def foo:
      if not bar:
        return true</pre>
    </div>
    <div class="col">
      <p>Inline code for comments</p>
      <pre>
I think you should use an
`&lt;addr&gt;` element here instead.</pre>
    </div>
  </div>

  </div>
</div>


    <div class="ajax-error-message">
      <p><span class="mini-icon exclamation"></span> Something went wrong with that request. Please try again. <a href="javascript:;" class="ajax-error-dismiss">Dismiss</a></p>
    </div>

    <div id="logo-popup">
      <h2>Looking for the GitHub logo?</h2>
      <ul>
        <li>
          <h4>GitHub Logo</h4>
          <a href="http://github-media-downloads.s3.amazonaws.com/GitHub_Logos.zip"><img alt="Github_logo" src="https://a248.e.akamai.net/assets.github.com/images/modules/about_page/github_logo.png?1315928456" /></a>
          <a href="http://github-media-downloads.s3.amazonaws.com/GitHub_Logos.zip" class="minibutton btn-download download"><span><span class="icon"></span>Download</span></a>
        </li>
        <li>
          <h4>The Octocat</h4>
          <a href="http://github-media-downloads.s3.amazonaws.com/Octocats.zip"><img alt="Octocat" src="https://a248.e.akamai.net/assets.github.com/images/modules/about_page/octocat.png?1315928456" /></a>
          <a href="http://github-media-downloads.s3.amazonaws.com/Octocats.zip" class="minibutton btn-download download"><span><span class="icon"></span>Download</span></a>
        </li>
      </ul>
    </div>

    
    
    
    <span id='server_response_time' data-time='0.06957' data-host='fe11'></span>
  </body>
</html>

