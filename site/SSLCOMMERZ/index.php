<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  max-width: 300px;
  margin: auto;
  text-align: center;
  font-family: arial;
}

.title {
  color: grey;
  font-size: 18px;
}

button {
  border: none;
  outline: 0;
  display: inline-block;
  padding: 8px;
  color: white;
  background-color: #000;
  text-align: center;
  cursor: pointer;
  width: 100%;
  font-size: 18px;
}

a {
  text-decoration: none;
  font-size: 22px;
  color: black;
}

button:hover, a:hover {
  opacity: 0.7;
}
</style>
</head>
<body>

<h2 style="text-align:center">SSLCommerz</h2>
<form action="checkout.php" method="get">
<div class="card">
  <img src="/w3images/team2.jpg" alt="John" style="width:100%">
  <h1>Enter Amount</h1>
    <p class="title"><input type="number" name="amount" id="amount"></p>

  <p>
    <input type="submit" value="Payment">
    <!-- <button>Contact</button></p> -->
</div>
</from>

</body>
</html>
