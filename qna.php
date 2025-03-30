<?php
include "./parts/header.php";
include "./parts/nav.php";
?>

  <main>
    <section class="banner">
      <div class="container text-white">
        <h1>Q&A</h1>
      </div>
    </section>
    <section class="container">
      <div class="row">
        <div class="col-100 text-center">
          <p><strong><em>Elit culpa id mollit irure sit. Ex ut et ea esse culpa officia ea incididunt elit velit veniam qui. Mollit deserunt culpa incididunt laborum commodo in culpa.</em></strong></p>
        </div>
      </div>
    </section>
      <section class="container">
        <?php
            include_once "classes/QnA.php";
            use otazkyodpovede\QnA;

            $qna = new QnA();
            //$qna->resetQnA();
            $qna->insertQnA(); //Najprv vložíme nové dáta (ak sú), potom zobrazíme otázky a odpovede
            $qna->showQnA();
        ?>
      </section>
    </section>
  </div>
  </main>

    <?php
    $include_path = "./parts/footer.php";
    if (!include($include_path)) {
        echo "Failed to include $include_path";
    }
    ?>

<script src="js/accordion.js"></script>
<script src="js/menu.js"></script>
</body>
</html>