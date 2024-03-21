<?php if ($linkObject): ?>
    <?php
        // Check if link is page, and if it still exists or is accessible
        if ($linkObject->linkType() == 'page') {
            $destination = page($linkObjectFields->link()->value());
            if (
                (!$destination) ||
                (!$destination->exists()) ||
                (!$destination->isListed())
            ) { return; }
        }
    ?>
    <?php $url = $linkObjectFields->link()->toUrl(); ?>
    <?php if ($url): ?>
        <?php
            // Set linkText
            $linktext = $linkObject->linkText();
            // Set classes
            $class = $linkObjectFields->classes()->isNotEmpty() ? $linkObjectFields->classes()->value() : null;
            // Merge in classes from the method
            if (isset($classes)) {
                $class = $classes . " " . $class;
            }
            // Set openInNewWindow
            $openInNewWindow = false;
            if ($linkObjectFields->openinnewwindow()->toBool()) {
                $openInNewWindow = true;
            }
        ?>
        <a
            href="<?= $url ?>"
            <?php if ($class): ?>
                class="<?= $class ?>"
            <?php endif ?>
            <?php if ($openInNewWindow): ?>
                target="_blank" rel="noopener noreferrer"
            <?php endif ?>
        >
            <?= $linktext ?>
        </a>
    <?php endif ?>
<?php endif ?>
