<div class="posts">
    <section class="post">
        <header class="post-header">
            <h2 class="post-title"><?php echo $ip ?></h2>
            <p class="post-meta">Hits: <?php echo $hash['hits'] ?> Latest: <?php echo strftime('%Y-%m-%d %H:%M:%S', $hash['latest']) ?> (<?php echo seconds_to_words(time() - $hash['latest']) ?> ago)</p>
        </header>
        <div class="post-description">
            <p><a href="<?php echo $baseUrl ?>">Back to scoreboard</a></p>
            <table class="pure-table pure-table-horizontal pure-table-striped">
                <thead>
                <tr>
                    <th>Host</th>
                    <th>Service</th>
                    <th>Time</th>
                    <th>Time ago</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($events as $event): ?>
                    <tr>
                        <td><?php echo E($event['host']) ?></td>
                        <td><?php echo E($event['service']) ?></td>
                        <td><?php echo strftime('%Y-%m-%d %H:%M:%S', $event['time']) ?></td>
                        <td><?php echo seconds_to_words(time() - $event['time']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>
