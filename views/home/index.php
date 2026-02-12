<?php $this->layout("layout", ["title" => "Homepage - Strooiwagen Management"]) ?>

<div id="homepage">
    <!-- Homepage Welcome -->
    <section class="home-welcome">
    <div class="">
      <h1>Welkom — overzicht strooiwagens</h1>
      <p>Actuele inzet, weer en gladheidsinformatie in één oogopslag.</p>
    </div>
    <div class="page-date">
      <span><?= $name ?></span>
      <span><?= $time ?></span>
    </div>
  </section>

<!-- Weather Status -->
    <section class="weather-bar">
        <div class="weather-item">
      <h4>Temperatuur (Sneek)</h4>
      <div class="value"><?= $sneekTemp ?> °C</div>
        </div>
        <div class="weather-item">
            <h4>Zicht</h4>
      <div class="value"><?= $sight ?>m</div>
        </div>
        <div class="weather-item">
            <h4>Weeromschrijving</h4>
      <div class="value"><?= $wheatherSummary ?></div>
        </div>
    </section>

    <!-- Card -->
    <section class="cards-grid">
    <div class="card stat">
      <h3>Strooiwagens nodig</h3>
      <div class="number"><?= $saltingWagonsNeeded ?></div>
    </div>

    <div class="card">
      <h3><?= $verw ?></h3>
      <p>
        <?= $lText ?>
      </p>
    </div>
  </section>

</div>