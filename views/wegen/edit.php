<?php $this->layout("layout", ["title" => "Weg Bewerken"]) ?>

<div id="create-form-container">
  <div class="form-card">
    <div class="form-header">
      <h1>Weg Bewerken</h1>
      <button type="button" class="close-btn" onclick="window.location.href='/wegen/<?= $road->getId() ?>'">&times;</button>
    </div>

    <form method="POST" class="road-form">
      <div class="form-grid">
        <!-- Naam -->
        <div class="form-group">
          <label for="naam" class="form-label">Naam</label>
          <input 
            type="text" 
            id="naam" 
            name="name" 
            class="form-input" 
            placeholder="Naam van de weg"
            value="<?= htmlspecialchars($road->getName()) ?>"
            required
          />
        </div>

        <!-- Locatie -->
        <div class="form-group">
          <label for="locatie" class="form-label">Locatie</label>
          <input 
            type="text" 
            id="locatie" 
            name="location" 
            class="form-input" 
            placeholder="Locatie van de weg"
            value="<?= htmlspecialchars($road->getLocation()) ?>"
            required
          />
        </div>

        <!-- Duur -->
        <div class="form-group">
          <label for="duur" class="form-label">Duur</label>
          <input 
            type="text" 
            id="duur" 
            name="saltingTime" 
            class="form-input" 
            placeholder="Duur van strooien"
            value="<?= htmlspecialchars($road->getSaltingTime()) ?>"
            required
          />
        </div>

        <!-- Strooien bij 0° -->
        <div class="form-group">
          <label for="strooien-0" class="form-label">Strooien bij 0°</label>
          <input 
            type="text" 
            id="strooien-0" 
            name="frequency_0" 
            class="form-input" 
            placeholder="Bijv. 1"
            value="<?= htmlspecialchars($road->getFrequencyForTemp(-5, 0) ?? '') ?>"
          />
        </div>

        <!-- Strooien bij -5° -->
        <div class="form-group">
          <label for="strooien-5" class="form-label">Strooien bij -5°</label>
          <input 
            type="text" 
            id="strooien-5" 
            name="frequency_5" 
            class="form-input" 
            placeholder="Bijv. 3"
            value="<?= htmlspecialchars($road->getFrequencyForTemp(-10, -5) ?? '') ?>"
          />
        </div>

        <!-- Strooien bij -10° -->
        <div class="form-group">
          <label for="strooien-10" class="form-label">Strooien bij -10°</label>
          <input 
            type="text" 
            id="strooien-10" 
            name="frequency_10" 
            class="form-input" 
            placeholder="Bijv. 5"
            value="<?= htmlspecialchars($road->getFrequencyForTemp(-15, -10) ?? '') ?>"
          />
        </div>
      </div>

      <button type="submit" class="submit-btn">Opslaan</button>
    </form>
  </div>
</div>
