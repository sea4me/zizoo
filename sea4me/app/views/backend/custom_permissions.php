<?php

echo '<b>Here is an example how to use custom permissions</b><br/><br/>';

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

// Build drop down menu
foreach ($roles as $role) {
    $options[$role->id] = $role->name;
}

// Change allowed uri to string to be inserted in text area
if (!empty($allowed_uri)) {
    $allowed_uri = implode("\n", $allowed_uri);
}

if (empty($edit)) {
    $edit = FALSE;
}

if (empty($delete)) {
    $delete = FALSE;
}

// Build form
echo form_open($this->uri->uri_string());

$this->table->add_row(
        form_label('Role', 'role_name_label'), form_dropdown('role', $options), form_submit('show', 'Show permissions')
);

$this->table->add_row(
        form_checkbox('edit', '1', $edit), form_label('Allow edit', 'edit_label')
);

$this->table->add_row(
        form_checkbox('delete', '1', $delete), form_label('Allow delete', 'delete_label')
);

echo '<div class="clsUser_Buttons"><ul class="clearfix"><li>';
echo form_submit('save', 'Save Permissions');
echo '</li></ul></div>';

echo $this->table->generate();

echo 'Open ' . anchor('auth/custom_permissions/') . ' to see the result, try to login using user that you have changed.<br/>';
echo 'If you change your own role, you need to relogin to see the result changes.';

echo form_close();
?>