// scanner.js - uses html5-qrcode from CDN
function showMessage(txt){ document.getElementById('result').innerText = txt; }

function onScanSuccess(decodedText, decodedResult){
    // Send to mark_attendance.php via POST fetch
    fetch('mark_attendance.php', {
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:'roll_no=' + encodeURIComponent(decodedText)
    }).then(r=>r.text()).then(txt=> showMessage(txt) ).catch(e=> showMessage('Error: '+e));
}

function onScanFailure(error){ /* ignore */ }

let html5QrcodeScanner = new Html5QrcodeScanner('reader',{ fps: 10, qrbox: 250 });
html5QrcodeScanner.render(onScanSuccess, onScanFailure);