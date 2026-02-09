<?php $this->layout("layout", ["title" => "Weg Details"]) ?>

<div id="roadsTabel">

<h1><?= $road->getName() ?> - Details</h1>

<div class="road-actions">
    <div>

        <button onclick="window.location.href='/wegen'" class="update-btn">← Terug naar overzicht</button>
        <button onclick="window.location.href='/wegen/<?= $road->getId() ?>/edit'" class="update-btn">Bewerken</button>
    </div>
    <button onclick="if(confirm('Weet je zeker dat je deze weg wilt verwijderen?')) window.location.href='/wegen/<?= $road->getId() ?>/delete'" class="delete-btn">Verwijderen</button>
</div>

<table>
    <thead>
        <tr>
            <th>Naam</th>
            <th>Locatie</th>
            <th>Duur</th>
            <th>0°</th>
            <th>-5°</th>
            <th>-10°</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?= $road->getName() ?></td>
            <td><?= $road->getLocation() ?></td>
            <td><?= $road->getSaltingTime() . "m" ?></td>
            <td><?= $road->getFrequencyForTemp(-5, 0) ?? '-' ?></td>
            <td><?= $road->getFrequencyForTemp(-10, -5) ?? '-' ?></td>
            <td><?= $road->getFrequencyForTemp(-15, -10) ?? '-' ?></td>
        </tr>
    </tbody>
</table>    


</div>
