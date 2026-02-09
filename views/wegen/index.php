<?php $this->layout("layout", ["title" => "Wegen"]) ?>

<div id="roadsTabel">

<h1>Overzicht van alle wegen.</h1>

<table >
    <thead>
        <tr>
            <th>Naam</th>
            <th>Locatie</th>
            <th>Duur</th>
            <th>0°</th>
            <th>-5°</th>
            <th>-10°</th>
            <th>Acties</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($roads as $road): ?>
        <tr onclick="window.location.href='/wegen/<?= $road->getId() ?>'" style="cursor: pointer;">
            <td><?= $road->getName() ?></td>
            <td><?= $road->getLocation() ?></td>
            <td><?= $road->getSaltingTime() . "m" ?></td>
            <td><?= $road->getFrequencyForTemp(-5, 0) ?? '-' ?></td>
            <td><?= $road->getFrequencyForTemp(-10, -5) ?? '-' ?></td>
            <td><?= $road->getFrequencyForTemp(-15, -10) ?? '-' ?></td>
            <td>
                <div class="actions" onclick="event.stopPropagation()">
                    <button onclick="window.location.href='/wegen/<?= $road->getId() ?>/edit'" class="update-btn">Bewerken</button>
                    <button onclick="if(confirm('Weet je zeker dat je deze weg wilt verwijderen?')) window.location.href='/wegen/<?= $road->getId() ?>/delete'" class="delete-btn">Verwijderen</button>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>    
</div>
