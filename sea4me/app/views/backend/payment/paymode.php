<?php

echo form_open('backend/payment/paymode');

//Show Flash Message

if ($msg = $this->session->flashdata('flash_message')) {
    echo $msg;
}

$tmpl = array(
    'table_open' => '<table class="table" border="0" cellpadding="4" cellspacing="0">',
    'heading_row_start' => '<tr>',
    'heading_row_end' => '</tr>',
    'heading_cell_start' => '<th>',
    'heading_cell_end' => '</th>',
    'row_start' => '<tr>',
    'row_end' => '</tr>',
    'cell_start' => '<td>',
    'cell_end' => '</td>',
    'row_alt_start' => '<tr>',
    'row_alt_end' => '</tr>',
    'cell_alt_start' => '<td>',
    'cell_alt_end' => '</td>',
    'table_close' => '</table>'
);

$this->table->set_template($tmpl);

$this->table->set_heading('', translate_admin('Commission Type'), translate_admin('Commission Fees'), translate_admin('Is Premium?'));

foreach ($payMode->result() as $row) {
    if ($row->is_premium == 1) {
        $is_premium = 'Yes';
        $change_to = translate_admin('Change to free mode');
    } else {
        $is_premium = 'No';
        $change_to = translate_admin('Change to premium mode');
    }

    if ($row->is_fixed == 1) {
        $commission = $row->fixed_amount;
    } else {
        $commission = $row->percentage_amount . '%';
    }

    $change = '<a href="' . admin_url('payment/paymode/' . $row->id) . '"><img src="' . base_url() . 'images/change.jpg" title="' . $change_to . '" alt="' . $change_to . '" /></a>';

    $this->table->add_row(
            form_checkbox('check[]', $row->id), $row->mod_name, $commission, $is_premium . '&nbsp;&nbsp;&nbsp;' . $change
    );
}


//echo form_open($this->uri->uri_string());
echo '<div class="clsUser_Buttons"><ul class="clearfix"><li>';
echo form_submit('edit', translate_admin('Edit Commission Settings'));
echo '</li></ul></div>';


echo $this->table->generate();

echo form_close();
?>