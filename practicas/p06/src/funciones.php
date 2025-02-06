<?php
  function es_multiplo7y5($num) {
    $num = $_GET['numero'];
    if ($num%5==0 && $num%7==0)
    {
      echo '<h3>R= El número '.$num.' SÍ es múltiplo de 5 y 7.</h3>';
    }
    else
    {
      echo '<h3>R= El número '.$num.' NO es múltiplo de 5 y 7.</h3>';
    }
  }

  function print_nombreyemail($name, $email) {
    $name=$_POST["name"];
    $email=$_POST["email"];

    echo $name;
    echo '<br>';
    echo $email;
  }
?>