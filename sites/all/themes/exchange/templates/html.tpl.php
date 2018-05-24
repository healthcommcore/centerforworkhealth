<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" version="XHTML+RDFa 1.0" dir="<?php print $language->dir; ?>"<?php print $rdf_namespaces; ?>>

<head profile="<?php print $grddl_profile; ?>">
  <?php print $head; ?>
  <title><?php print $head_title; ?></title>
  <?php print $styles; ?>
	<!--[if lt IE 9]>
		<script src="<?php print $base_path . $directory; ?>/js/html5.js"></script>
	<![endif]-->
  <?php print $scripts; ?>
<!-- GOOGLE ANALYTICS -->
  <script type="text/javascript">
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-17833255-1', 'harvard.edu');
    ga('send', 'pageview');
  </script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>
  <script src='https://www.google.com/recaptcha/api.js' async defer></script>
</head>
<body class="<?php print $classes; ?>" <?php print $attributes;?>>
  <div id="skip-link">
    <a href="#main-content" class="element-invisible element-focusable"><?php print t('Skip to main content'); ?></a>
  </div>
  <?php print $page_top; ?>
  <?php print $page; ?>
  <?php print $page_bottom; ?>
  <?php //require_once('recaptchalib.php'); ?>

<!-- Modal for pdf download tracking -->
<div class="modal fade" id="tracking-modal" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
        <h4 class="modal-title">Download the document</h4>
      </div>
      <form id="tracking-form" action="/tracking/tracking.php" method="post">
        <div class="modal-body">
          <p>To download this document, please provide the following information.  We may email you in the future to learn how our resource is being used in your organization. Thank you.</p>
          <div class="form-item form-type-textfield form-item-name">
            <label>First name</label>
            <input type="text" id="first_name" name="first_name" class="form-text" placeholder="First name" required />
          </div>
          <div class="form-item form-type-textfield form-item-name">
            <label>Last name</label>
            <input type="text" id="last_name" name="last_name" class="form-text" placeholder="Last name" required />
          </div>
          <div class="form-item form-type-textfield form-item-name">
            <label>Organization</label>
            <input type="text" id="organization" name="organization" class="form-text" placeholder="Organization" required />
          </div>
          <div class="form-item form-type-textfield form-item-name">
            <label>Email</label>
            <input type="text" id="email"  name="email" class="form-text" placeholder="Email" required />
          </div>
          <input data-url="" type="hidden" name="tracking-docname" id="tracking-docname" />
          <!--<div class="g-recaptcha" data-sitekey="6LeaDjkUAAAAAMSnQ3OWoiDNlesSDxDMgXU0pZbt"> </div>-->
          <!--<input type="hidden" name="recaptcha_field" id="recaptcha_field" />-->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button id="tracking-click" type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Validation -->
<script>
  (function($) {

    var trackingModal = $('#tracking-modal');
    trackingModal.hide();
    $('.activate-modal').on('click', function (e) {
      trackingModal.show();
      console.log(e.target.dataset.docname);
      var docname = e.target.dataset.docname;
      var href = e.target.href;
      var regex = new RegExp(docname);
      if ( !regex.test(document.cookie)) {
        $('#tracking-modal').modal('show');
        $('#tracking-modal #tracking-docname').attr('data-url', href);
        $('#tracking-modal #tracking-docname').val(docname);
      }
      else {
        downloadFile(href);
      }
      e.preventDefault();
    });

    $('#tracking-click').on('click', function() {
      $('#tracking-form').validate({
        rules: {
          email: {
            required: true,
            email: true
          },
          recaptcha_field: {
            required: function () {
              if (grecaptcha.getResponse() == '') {
                return true;
              }
              else {
                return false;
              }
            }
          }
        },
        submitHandler: function (form) {
          form.submit();
          $('#tracking-modal').modal('hide');
          trackingModal.hide();
          var date = new Date('2050, 1, 1');
          var docname = $('#tracking-docname').val();
          var href = $('#tracking-docname').attr('data-url');
          date = date.toUTCString();
          document.cookie= docname + "=true;expires=" + date;
          downloadFile(href);
        }
      });
    });

    function downloadFile(href) {
      if (href) {
        window.open(href, '_blank');
      }
    }

  })(jQuery);
</script>

<!-- Popup window for external links -->
<script>
(function($){
	var extLinks = $('.popup');
	var width = $(window).width() / 1.5;
	var height = $(window).height();
	var xPos = window.screenX + (window.outerWidth - width) / 2;
	var yPos = window.screenY + (window.outerHeight - height) / 2;
	var options = "resizable=yes,menubar=yes,toolbar=yes,status=yes,location=yes," + 
		"height=" + height + ",width=" + width + 
		",top=" + yPos + ",left=" + xPos;
	for(var i = 0; i < extLinks.length; i++){
		extLinks[i].onclick = function(){
			window.open(this.href, this.value, options);
			return false;
		}
	}
})(jQuery);
</script>
</body>
</html>
