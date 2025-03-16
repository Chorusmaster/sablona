<?php
include "./parts/header.php";
include "./parts/nav.php";
?>

        <main>
            <section class="banner">
                <div class="container text-white">
                    <h1>Portfólio</h1>
                </div>
            </section>
              <section class="container">
                  <?php
                    require_once "./parts/functions.php";
                    insertPortfolio();
                  ?>
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