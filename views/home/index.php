<?php $this->layout("layout", ["title" => "Homepage - Strooiwagen Management"]) ?>

<?php 
$date = new DateTime();

$dateOfNow = $date->format("d-m-Y");
$timeOfNow = $date->format("H:i");


?>

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
            <h4>Gemiddelde Temperatuur</h4>
            <div class="value"><?= $avgTemp ?> °C</div>
        </div>
        <div class="weather-item">
            <h4>Wegen met strooien nodig</h4>
            <div class="value"><?= count($weatherData) > 0 ? array_sum(array_map(fn($w) => $w['needsSalting'] ? 1 : 0, $weatherData)) : 0 ?></div>
        </div>
        <div class="weather-item">
            <h4>Totaal wegen</h4>
            <div class="value"><?= count($weatherData) ?></div>
        </div>
    </section>

    <!-- Card -->
    <section class="cards-grid">
    <div class="card stat">
      <h3>Aantal strooiwagens</h3>
      <div class="number">5</div>
    </div>

    <div class="card">
      <h3>Gladheid