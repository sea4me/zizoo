<ul class="subnav" id="submenu">

    <?php
    if ($this->uri->segment(1) == 'travelling' && $this->uri->segment(2) == 'current_trip')
        echo '<li class="active">'; else
        echo '<li>';

    echo anchor('travelling/current_trip', translate("Current Trips"));

    echo '</li>';
    ?>

    <?php
    if ($this->uri->segment(1) == 'travelling' && $this->uri->segment(2) == 'upcomming_trips')
        echo '<li class="active">'; else
        echo '<li>';

    echo anchor('travelling/upcomming_trips', translate("Upcoming Trips"));

    echo '</li>';
    ?>

    <?php
    if ($this->uri->segment(1) == 'travelling' && $this->uri->segment(2) == 'previous_trips')
        echo '<li class="active">'; else
        echo '<li>';

    echo anchor('travelling/previous_trips', translate("Previous Trips"));

    echo '</li>';
    ?>

    <?php
    if ($this->uri->segment(1) == 'travelling' && $this->uri->segment(2) == 'starred_items')
        echo '<li class="active">'; else
        echo '<li>';

    echo anchor('travelling/starred_items', translate("Starred Items"));

    echo '</li>';
    ?>

</ul>