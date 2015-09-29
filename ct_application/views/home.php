<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <link rel="apple-touch-icon" href="apple-touch-icon-57.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="apple-touch-icon-72.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="apple-touch-icon-114.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="apple-touch-icon-144.png" />
    <link rel="icon" href="library/images/favicon.ico">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/library/images/win8-tile-icon.png">
    <title>H-hat Foundation 5 Boilerplate</title>
    <link rel="stylesheet" href="library/css/app.css" />
    <!-- <script src="library/bower_components/modernizr/modernizr.js"></script> -->
  </head>

    <!--[if IE ]>
       <body class="ie">
    <![endif]-->
    <!--[if !IE]>-->
       <body>
    <!--<![endif]-->
    <div class="row">
      <div class="large-12 columns">
        <h1>Welcome to Foundation</h1>
      </div>
    </div>

    <div class="row">
      <div class="large-12 columns">
        <div class="panel">
          <h3>We&rsquo;re stoked you want to try Foundation! </h3>
            <?php
            echo "<br>ENVIRONMENT: " . ENVIRONMENT;
            echo "<br>Site URL: " . $this->config->site_url();
            echo "<br>Base URL: " . $this->config->base_url();
            echo "<br>System URL: " . $this->config->system_url();
            ?>
          <p>To get going, this file (index.html) includes some basic styles you can modify, play around with, or totally destroy to get going.</p>
          <p>Once you've exhausted the fun in this document, you should check out:</p>
          <div class="row">
            <div class="large-4 medium-4 columns">
          <p><a href="http://foundation.zurb.com/docs">Foundation Documentation</a><br />Everything you need to know about using the framework.</p>
        </div>
            <div class="large-4 medium-4 columns">
              <p><a href="http://github.com/zurb/foundation">Foundation on Github</a><br />Latest code, issue reports, feature requests and more.</p>
            </div>
            <div class="large-4 medium-4 columns">
              <p><a href="http://twitter.com/foundationzurb">@foundationzurb</a><br />Ping us on Twitter if you have questions. If you build something with this we'd love to see it (and send you a totally boss sticker).</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="large-8 medium-8 columns">
        <h5>Here&rsquo;s your basic grid:</h5>
        <!-- Grid Example -->

        <div class="row">
          <div class="large-12 columns">
            <div class="callout panel">
              <p><strong>This is a twelve column section in a row.</strong> Each of these includes a div.panel element so you can see where the columns are - it's not required at all for the grid.</p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="large-6 medium-6 columns">
            <div class="callout panel">
              <p>Six columns</p>
            </div>
          </div>
          <div class="large-6 medium-6 columns">
            <div class="callout panel">
              <p>Six columns</p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="large-4 medium-4 small-4 columns">
            <div class="callout panel">
              <p>Four columns</p>
            </div>
          </div>
          <div class="large-4 medium-4 small-4 columns">
            <div class="callout panel">
              <p>Four columns</p>
            </div>
          </div>
          <div class="large-4 medium-4 small-4 columns">
            <div class="callout panel">
              <p>Four columns</p>
            </div>
          </div>
        </div>

        <hr />

        <h5>We bet you&rsquo;ll need a form somewhere:</h5>
        <form>
          <div class="row">
            <div class="large-12 columns">
              <label>Input Label</label>
              <input type="text" placeholder="large-12.columns" />
            </div>
          </div>
          <div class="row">
            <div class="large-4 medium-4 columns">
              <label>Input Label</label>
              <input type="text" placeholder="large-4.columns" />
            </div>
            <div class="large-4 medium-4 columns">
              <label>Input Label</label>
              <input type="text" placeholder="large-4.columns" />
            </div>
            <div class="large-4 medium-4 columns">
              <div class="row collapse">
                <label>Input Label</label>
                <div class="small-9 columns">
                  <input type="text" placeholder="small-9.columns" />
                </div>
                <div class="small-3 columns">
                  <span class="postfix">.com</span>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="large-12 columns">
              <label>Select Box</label>
              <select>
                <option value="husker">Husker</option>
                <option value="starbuck">Starbuck</option>
                <option value="hotdog">Hot Dog</option>
                <option value="apollo">Apollo</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="large-6 medium-6 columns">
              <label>Choose Your Favorite</label>
              <input type="radio" name="pokemon" value="Red" id="pokemonRed"><label for="pokemonRed">Radio 1</label>
              <input type="radio" name="pokemon" value="Blue" id="pokemonBlue"><label for="pokemonBlue">Radio 2</label>
            </div>
            <div class="large-6 medium-6 columns">
              <label>Check these out</label>
              <input id="checkbox1" type="checkbox"><label for="checkbox1">Checkbox 1</label>
              <input id="checkbox2" type="checkbox"><label for="checkbox2">Checkbox 2</label>
            </div>
          </div>
          <div class="row">
            <div class="large-12 columns">
              <label>Textarea Label</label>
              <textarea placeholder="small-12.columns"></textarea>
            </div>
          </div>
        </form>
      </div>

      <div class="large-4 medium-4 columns">
        <h5>Try one of these buttons:</h5>
        <p><a href="#" class="small button">Simple Button</a><br/>
        <a href="#" class="small radius button">Radius Button</a><br/>
        <a href="#" class="small round button">Round Button</a><br/>
        <a href="#" class="medium success button">Success Btn</a><br/>
        <a href="#" class="medium alert button">Alert Btn</a><br/>
        <a href="#" class="medium secondary button">Secondary Btn</a></p>
        <div class="panel">
          <h5>So many components, girl!</h5>
          <p>A whole kitchen sink of goodies comes with Foundation. Check out the docs to see them all, along with details on making them your own.</p>
          <a href="http://foundation.zurb.com/docs/" class="small button">Go to Foundation Docs</a>
        </div>
      </div>
    </div>

    <div class="row">
        <div class="large-12 columns">
            <a href='<?php echo base_url(); ?>LangToggle/switch_language/english?returnUrl=<?php echo uri_string(); ?>'>English</a>
            <a href='<?php echo base_url(); ?>LangToggle/switch_language/french?returnUrl=<?php echo uri_string(); ?>'>French</a>
            Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?>
        </div>
    </div>

    <input type="hidden" id="txtDebug" name="txtDebug" value="true" />

    <script src="library/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="library/bower_components/foundation/js/foundation.min.js"></script>
    <script src="library/js/app.js"></script>

  </body>
</html>