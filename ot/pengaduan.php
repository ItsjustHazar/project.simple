<!DOCTYPE html>
<html>
<head>
  <style>
    *{
      font-family: Arial, sans-serif;
    }
    form{
      margin: 15px 5px;
      width: 500px;
      font-size: 16px;
    }
    form h1{
      text-align: center;
    }
    form label{
      display: block;
      margin-bottom: 5px;
    }
    form input, form textarea{
      width: 100%;
      padding: 5px;
      margin-bottom: 10px;
      box-sizing: border-box;
      resize: vertical;
    }
    form button{
      background: #4CAF50;
      color: white;
      padding: 10px 15px;
      margin-top: 5px;
      border: none;
      cursor: pointer;
    }
    form button:hover{
      background: green;
    }
  </style>
</head>
<body>
  <form>
    <h1>Form Pengaduan Orang Tua</h1>
    <label for="nama">Nama Orang Tua</label>
    <input type="text" class="name" id="nama">

    <label for="email">Email</label>
    <input type="text" class="email" id="email">

    <label for="kelas">Kelas</label>
    <input type="text" class="class" id="kelas">

    <label for="message">Message</label>
    <textarea class="message" id="message"></textarea>
    <button type="button" onclick="sendwhatsapp();">Send Via WhatsApp</button>
  </form>

  <script>
    function sendwhatsapp(){
      var phonenumber = "+6281287960559";

      var name = document.querySelector(".name").value;
      var email = document.querySelector(".email").value;
      var kelas = document.querySelector(".class").value;
      var message = document.querySelector(".message").value;

      var url = "https://wa.me/" + phonenumber + "?text="
      +"*Nama Orang Tua :* "+name+"%0a"
      +"*Email :* "+email+"%0a"
      +"*Kelas:* "+kelas+"%0a"
      +"*Message :* "+message
      +"%0a%0a"
      +"This is an example of send HTML form data to WhatsApp";

      window.open(url, '_blank').focus();
    }
  </script>
</body>
</html>
