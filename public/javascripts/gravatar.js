const gravatarUrl = "https://www.gravatar.com/avatar/";

(function () {
   const gravatarImages = document.querySelectorAll("[data-gravatar]");
   console.log(gravatarImages);  ``
   for (const gravatarImage of gravatarImages) {
      const email = gravatarImage.dataset.email;
      const emailHash = CryptoJS.MD5(email);
      gravatarImage.src = `${gravatarUrl}${emailHash}`;
   }
})();
