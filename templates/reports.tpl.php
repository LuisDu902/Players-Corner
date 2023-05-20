<?php function drawStats(array $stats)
{ ?>
    <section class="round-border" id="overview">
        <header class="title" id="overview-title">Overview</header>
        <table>
            <thead id="overview-fields">
                <tr>
                    <th>Total tickets</th>
                    <th>Tickets created today</th>
                    <th>Tickets created this week</th>
                    <th>Tickets created this month</th>
                </tr>
            </thead>
            <tbody class="center">
                <tr>
                    <td>
                        <?= $stats['total_tickets'] ?>
                    </td>
                    <td>
                        <?= $stats['tickets_created_today'] ?>
                    </td>
                    <td>
                        <?= $stats['tickets_created_this_week'] ?>
                    </td>
                    <td>
                        <?= $stats['tickets_created_this_month'] ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </section>
    <section id="all-ticket-stats">
        <header class="title" id="tkt-stats-title">Ticket distribution</header>
        <canvas id="ticket-counts" class="graphics"></canvas>
    </section>
    <section id="ticket-distribution" class="container">
        <article class="round-border">
            <h3>Tickets by department</h3>
            <canvas id="all-tkt-dept" class="graphics"></canvas>
        </article>
        <article class="round-border">
            <h3>Tickets by status</h3>
            <canvas id="all-tkt-status" class="graphics"></canvas>
        </article>
        <article class="round-border">
            <h3>Tickets by priority</h3>
            <canvas id="all-tkt-priority" class="graphics"></canvas>
        </article>

    </section>
<?php } ?>