<?php
// Get the host (e.g., example.com)
$host = $_SERVER['HTTP_HOST'];

// Determine the scheme (http or https)
$scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';

// Construct the base URL
$base_url_parsed = $scheme . '://' . $host;

?>

<iframe id="myIframe" src="<?= $base_url_parsed; ?>/CN/project/dashboard/medical/bloodbank.php" width="100%" frameborder="0" style="min-height: 100vh;"></iframe>

<script>
  function resizeIframe() {
    var iframe = document.getElementById('myIframe');
    var windowHeight = window.innerHeight;

    // Set the iframe height to the content's scroll height or at least the window height
    var newHeight = Math.max(iframe.contentWindow.document.body.scrollHeight, windowHeight);
    iframe.style.height = newHeight + 'px';
  }

  // Trigger the resize once the iframe content is fully loaded
  document.getElementById('myIframe').onload = function() {
    resizeIframe();
  };
</script>
