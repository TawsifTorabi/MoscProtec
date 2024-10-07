<?php
// Get the host (e.g., example.com)
$host = $_SERVER['HTTP_HOST'];

// Determine the scheme (http or https)
$scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';

// Construct the base URL
$base_url_parsed = $scheme . '://' . $host;

?>

<!-- Use the constructed base URL in the iframe src -->
<iframe id="myIframe" src="<?= $base_url_parsed; ?>/CN/project/dashboard/medical/dashboard.php" width="100%" frameborder="0"></iframe>

<script>
  function resizeIframe() {
    var iframe = document.getElementById('myIframe');
    iframe.style.height = iframe.contentWindow.document.body.scrollHeight + 'px';
  }

  // Trigger the resize once the iframe content is fully loaded
  document.getElementById('myIframe').onload = function() {
    resizeIframe();
  };
</script>
