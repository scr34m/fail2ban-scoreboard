<div class="posts">
    <section class="post">
        <header class="post-header">
            <h2 class="post-title">Scoreboard</h2>
            <p class="post-meta">List of tracked IP addresses blocked by reporting fail2ban services.</p>
        </header>
        <div class="post-description">
            <ol>
                <?php foreach ($ips as $ip => $score): ?>
                    <li><a href="<?php echo $baseUrl . 'info/' . $ip ?>"><?php echo $ip ?></a> (<?php echo $score ?>)</li>
                <?php endforeach; ?>
            </ol>
            <table class="pure-table pure-table-horizontal pure-table-striped">
                <thead>
                <tr>
                    <th>Host</th>
                    <th>Service</th>
                    <th>IP</th>
                    <th>Time</th>
                    <th>Time ago</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($events as $event): ?>
                    <tr>
                        <td><?php echo E($event['host']) ?></td>
                        <td><?php echo E($event['service']) ?></td>
                        <td><?php echo E($event['ip']) ?></td>
                        <td><?php echo strftime('%Y-%m-%d %H:%M:%S', $event['time']) ?></td>
                        <td><?php echo seconds_to_words(time() - $event['time']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>

