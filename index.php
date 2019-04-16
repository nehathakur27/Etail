<!DOCTYPE html>
<html>
<head>
<title>Excel Uploading PHP</title>
<link rel="stylesheet" href="master.css">
<link rel="stylesheet" href="/css/master.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <script type="text/javascript">
            $(document).bind('dragover', function (e) {
        var dropZone = $('.zone'),
            timeout = window.dropZoneTimeout;
        if (!timeout) {
            dropZone.addClass('in');
        } else {
            clearTimeout(timeout);
        }
        var found = false,
            node = e.target;
        do {
            if (node === dropZone[0]) {
                found = true;
                break;
            }
            node = node.parentNode;
        } while (node != null);
        if (found) {
            dropZone.addClass('hover');
        } else {
            dropZone.removeClass('hover');
        }
        window.dropZoneTimeout = setTimeout(function () {
        window.dropZoneTimeout = null;
            dropZone.removeClass('in hover');
        }, 100);
        });
    </script>
    <div class="bg-image">
    </div>
<div class="container">
<h1 style="color:black;">Upload Excel File</h1>
<form method="POST" action="upload.php" enctype="multipart/form-data">
    <div class="zone">
      <div id="dropZ">
        <i class="fa fa-cloud-upload" style="font-size:100px"></i>
        <div style="font-size: 25px">Drag and drop your file here</div>
        <span style="font-size: 25px">OR</span><br>
        <div class="selectFile">
          <label for="file" style="font-size: 25px;margin-left: 100px;">Select file</label>
          <input type="file" name="files" style="font-size: 15px" ><br><br>
          <input type="submit" name="upload" class="btn" value="Upload">
      </div>
      </div>
    </div>
</form>
</div>

</body>
</html>
