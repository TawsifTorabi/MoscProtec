<style>
  /* Style for the floating fixed button */
  #backButton {
    position: fixed;
    top: 6em;
    right: 2em;
    background-color: #007BFF;
    color: white;
    border: none;
    padding: 17px 20px;
    border-radius: 31%;
    font-size: 16px;
    cursor: pointer;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

  #backButton:hover {
    background-color: #0056b3;
  }

  /* Basic style for the iframe */
  iframe {
    width: 100%;
    height: 500px;
    border: 1px solid #ddd;
  }
</style>
<?php
// Get the host (e.g., example.com)
$host = $_SERVER['HTTP_HOST'];

// Determine the scheme (http or https)
$scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';

// Construct the base URL
$base_url_parsed = $scheme . '://' . $host;

?>

<iframe id="myIframe" src="<?= $base_url_parsed; ?>/CN/project/dashboard/counseling/dashboard.php" width="100%" frameborder="0" style="min-height: 87vh;"></iframe>

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
    //resizeIframe();
  };
</script>

<!-- Floating fixed button -->
<button id="backButton">⟵</button>

<script>
  // When the button is clicked, it will go back one step in iframe history
  document.getElementById('backButton').addEventListener('click', function() {
    var iframeWindow = document.getElementById('myIframe').contentWindow;
    iframeWindow.history.back();
  });
</script>