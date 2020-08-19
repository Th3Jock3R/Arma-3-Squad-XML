<?php
require_once 'Config.php';

$RANKS = [
  'Admin',
  'Moderator',
  'Supporter',
  'Veteran',
  'Mitglied',
  'Bewerber',
  'Rekrut',
];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $xmlold = $xml = simplexml_load_file(Config::$squad_xml);

  $xml->name  = substr(trim($_POST['name']),  0, 64);
  $xml->email = substr(trim($_POST['email']), 0, 64);
  $xml->web   = substr(trim($_POST['url']),   0, 64);
  $xml->title = substr(trim($_POST['title']), 0, 64);
  $xml->attributes()->nick = substr(trim($_POST['title']), 0, 64);

  unset($xml->member);



  $members = [];
  foreach ($_POST['member'] as $item) {
    $member = $xml->addChild('member');
    $member->addAttribute('id', substr(trim($item['id']), 0, 64));
    $member->addAttribute('nick', substr(trim($item['nick']), 0, 64));

    $member->addChild('name', substr(trim($item['name']), 0, 64));
    $member->addChild('email', "N/A");
    $member->addChild('icq', "N/A");
    $member->addChild('remark', substr(trim($item['remark']), 0, 64));
  }

  $xml->saveXML(Config::$squad_xml);

}

?>
<html lang="en" class="h-100">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Gabriel Weltermann">
    <title><?= Config::$name ?> - Squadverwaltung</title>

    <link href="css/bootstrap.min.css" rel="stylesheet" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  </head>
  <body class="d-flex flex-column h-100">

  <main role="main" class="flex-shrink-0">
    <div class="container">
      <h1><?= Config::$name ?> - Squad.XML Verwaltung</h1>
      <?php $xml = simplexml_load_file(Config::$squad_xml); ?>
      <hr>
      <form method="post">
        <h3>Basisinfos</h3>

        <div class="row">
          <div class="col-6">
            <div class="form-group">
              <label for="name">Name</label>
              <input type="name" class="form-control" id="name" aria-describedby="name" value="<?= $xml->name ?>" name="name" maxlength="64">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-6">
            <div class="form-group">
              <label for="name">E-Mail</label>
              <input type="email" class="form-control" id="email" aria-describedby="email" value="<?= $xml->email ?>" name="email" maxlength="64">
            </div>
          </div>
          <div class="col-6">
            <div class="form-group">
              <label for="url">URL</label>
              <input type="name" class="form-control" id="url" aria-describedby="url" value="<?= $xml->web ?>" name="url" maxlength="64">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-6">
            <div class="form-group">
              <label for="picture">Bild</label>
              <select name="picture" id="picture" class="form-control">
                <?php
                  foreach (scandir("../") as $item) {
                    if (preg_match('/(.*)\.paa$/', $item, $matches)) {
                      echo sprintf('<option value="%s">%s</option>', $item, $matches[1]);
                    }
                  }
                ?>
              </select>
            </div>
          </div>
          <div class="col-6">
            <div class="form-group">
              <label for="title">Titel</label>
              <input type="title" class="form-control" id="title" aria-describedby="title" value="<?= $xml->title ?>" name="title">
            </div>
          </div>
        </div>
        <hr>
        <h4>Mitglieder</h4>

        <div class="row">
          <div class="col text-right" style="margin-bottom: 1rem">
            <button type="button" id="addRow" class="btn btn-primary">Mitglied Hinzufügen</button>
          </div>
        </div>

        <table class="table" >
          <thead>
            <tr>
              <th>Steam-ID</th>
              <th>Nickname</th>
              <th>Name</th>
              <th>Rang</th>
              <th></th>
            </tr>
          </thead>
          <tbody id="members">
            <?php
              $i = 0;
              foreach ($xml->member as $item) {
                $i++;
            ?>
              <tr class="xmlrow">
                <td><input type="text" class="form-control" name="member[<?= $i ?>][id]"   value="<?= $item->attributes()->id ?>" required></td>
                <td><input type="text" maxlength="64" class="form-control" name="member[<?= $i ?>][nick]" value="<?= $item->attributes()->nick ?>"></td>
                <td><input type="text" maxlength="64" class="form-control" name="member[<?= $i ?>][name]" value="<?= $item->name ?>"></td>
                <td>
                  <select name="member[<?= $i ?>][remark]" class="form-control">
                    <?php


                    foreach ($RANKS as $rank) {
                      $selected = "";
                      error_log($item->remark);
                      if (trim($item->remark) === $rank || (trim($item->remark) === 'N/A' && $rank === 'Mitglied')) {
                        $selected = 'selected';
                      }
                      echo sprintf('<option value="%s" %s>%s</option>', $rank, $selected, $rank);
                    }
                    ?>
                  </select>
                </td>
                <td class="text-right">
                  <button type="button" class="btn btn-danger delete">Löschen</button>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>

        <div class="row">
          <div class="col text-right">
            <button class="btn btn-primary">Speichern</button>
          </div>
        </div>
      </form>



    </div>
  </main>



  <footer class="footer mt-auto py-3">
    <div class="container">
      <span class="text-muted">&copy; Gabriel Weltermann <?php echo date("Y") ?></span>
    </div>
  </footer>

  <script src="js/app.js"></script>

  </body>
</html>