<a href="#" class="card" onclick="alert('Aquí iría el detalle del evento: <?= $ev['titulo'] ?>')">
    
    <?php $img = $ev['poster'] ? "assets/img/".$ev['poster'] : "https://via.placeholder.com/300x170?text=".urlencode($ev['titulo']); ?>
    
    <img src="<?= $img ?>" alt="<?= htmlspecialchars($ev['titulo']) ?>">
    
    <div class="card-info">
        <h4 style="font-size: 0.9rem; margin-bottom: 5px; color: white;"><?= htmlspecialchars($ev['titulo']) ?></h4>
        <span style="font-size: 0.7rem; color: #98ca3f; font-weight: bold;">
            <?= date("d M", strtotime($ev['fecha'])) ?> • <?= htmlspecialchars($ev['ubicacion']) ?>
        </span>
    </div>
</a>