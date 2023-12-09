function validateRegistrationPassword() {
    // Haetaan syötekenttien elementit ja arvot
    var password = document.getElementById("password-input");
    var passwordRepeat = document.getElementById("pswd-repeat");
  
    // Vertaillaan salasanoja
    if (password.value != passwordRepeat.value) {
      // Jos salasanat eivät täsmää, näytetään virheilmoitus ja estetään formin lähetys
      alert("Salasanat eivät täsmää!");
      return false;
    } else {
      // Jos salasanat täsmäävät, sallitaan formin lähetys
      return true;
    }
  }