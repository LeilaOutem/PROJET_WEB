<?php
  //Session initialization
  session_start();
  
  // Destroying session
  if(session_destroy())
  {
    // GO to login page
    header("Location: index.php");
  }
?>