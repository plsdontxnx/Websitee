<?php
// No need to redefine isUserAuthenticated(), remove it from this file
?>
<nav>
  <div class="left-nav">
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="menu.php">Menu</a></li>
    </ul>
  </div>
  <div class="logo">
    <a href="#"><img src="images/cafe logo.png" alt="Cafe Logo"></a>
    <span><span class="go">GO</span><span class="fee">ffee</span></span>
  </div>
  <div class="right-nav">
    <ul>
      <li><a href="#">About Us</a></li>
      <li><a href="#">Contact</a></li>
      <li><a href="cart.php"><img src="images/shopping-cart.png" alt="Shopping Cart"></a></li>
      <?php if (isset($_SESSION['user_id'])): ?>
        <li><a href="#">Hello, <?php echo htmlspecialchars($_SESSION['fName']); ?>!</a></li>
        <li><a href="logout.php">Logout</a></li>
      <?php else: ?>
        <li><a href="login.php">Sign In</a></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>
