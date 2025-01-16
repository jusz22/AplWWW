<nav>
    <?php foreach ($carModels as $page => $name): ?>
    <a href="<?php echo $page; ?>.php"> 
        <div class="tile<?php echo ($currentPage === $page.'.php') ? ' active' : ''; ?>">
            <p><?php echo htmlspecialchars($name); ?></p>
        </div>
    </a>
    <?php endforeach; ?>
</nav>