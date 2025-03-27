<?php
include "./parts/header.php";
include "./parts/nav.php";
?>

    <main>
      <section class="banner">
        <div class="container text-white">
          <h1>Ďakujeme</h1>
        </div>
      </section>
      <section class="container">
        <div class="row">
          <div class="col-100 text-center">
              <h2>Ďakujeme za vyplnenie formulára</h2>
          </div>
        </div>
      </section>


    </main>

    <?php
    $include_path = "./parts/footer.php";
    if (!include($include_path)) {
        echo "Failed to include $include_path";
    }
    ?>

    <script src="js/menu.js"></script>
</body>
</html>