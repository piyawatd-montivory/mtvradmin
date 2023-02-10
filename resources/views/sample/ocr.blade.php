<html>
  <head>
    <meta HTTP-EQUIV="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body {
    color: #ccc;
    background: #080808;
    font-family: 'Century Gothic';
  }

    button {
      border: none;
      height: 24px;
      font-size: 14px;
      color: #eee;
      background-color: #88f;
      border-radius: 8px;
      margin: 0 8px;
      padding: 0 16px;
    }
    </style>
    <script src='https://unpkg.com/tesseract.js@4.0.2/dist/tesseract.min.js'></script>
  </head>
  <body>
    <video id="player" width="320" height="240" autoplay></video>
    <button id="capture">Capture</button>
    <canvas id="snapshot" width="320" height="240"></canvas>
    <textarea id="result" style="width:640px;height:240px;"></textarea>
    <script type="text/javascript">
        const player = document.getElementById('player')
        const snapshotZone = document.getElementById('snapshot')
        const captureButton = document.getElementById('capture')
        const result = document.getElementById('result')

        navigator.mediaDevices.getUserMedia({ video: true,audio:false }).then(stream => {
            player.srcObject = stream
        })

        captureButton.addEventListener('click', function() {
            const context = snapshot.getContext('2d')
            context.drawImage(player, 0, 0, snapshotZone.width, snapshotZone.height)
            // Tesseract.recognize(snapshotZone, 'jpn', { logger: m => console.log(m) }) // 日本語
            Tesseract.recognize(snapshotZone, 'eng', { logger: m => console.log(m) }) // 英語
                .then(({ data: { text } }) => {
                    result.value = text
                })
        })
    </script>
  </body>
</html>
