<?php
/**
 * @Created by          : Waris Agung Widodo (ido.alit@gmail.com)
 * @Date                : 21/05/2021 14:47
 * @File name           : daftar_admin.php
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */

defined('INDEX_AUTH') OR die('Direct access not allowed!');

// IP based access limitation
require LIB . 'ip_based_access.inc.php';
do_checkIP('smc');
do_checkIP('smc-membership');
// start the session
require SB . 'admin/default/session.inc.php';
require SIMBIO . 'simbio_GUI/table/simbio_table.inc.php';
require SIMBIO . 'simbio_GUI/form_maker/simbio_form_table_AJAX.inc.php';
require SIMBIO . 'simbio_GUI/paging/simbio_paging.inc.php';
require SIMBIO . 'simbio_DB/datagrid/simbio_dbgrid.inc.php';

// privileges checking
$can_read = utility::havePrivilege('membership', 'r');

if (!$can_read) {
    die('<div class="errorBox">' . __('You are not authorized to view this section') . '</div>');
}

?>
    <div class="menuBox">
        <div class="menuBoxInner printIcon">
            <div class="per_title">
                <h2><?php echo __('Pendaftaran Mandiri'); ?></h2>
            </div>
        </div>
    </div>
<?php

// menampilkan data anggota yang sudah mendaftar
$grid = new simbio_datagrid();
$grid->setSQLColumn('member_id', 'member_name', 'member_email', 'input_date', 'member_id');
function lihat($dbs, $data, $index) {
    $adm = AWB;
    return <<<HTML
<a class="btn-sm btn btn-primary" href="{$adm}/modules/membership/index.php?itemID={$data[$index]}&amp;detail=true&amp;ajaxload=1&amp;" postdata="itemID={$data[$index]}&amp;detail=true" title="LIHAT">LIHAT</a>
HTML;
}
$grid->modifyColumnContent(4, 'callback{lihat}');
//$criteria = 'is_new = 1 ';
//$grid->setSQLCriteria($criteria);
echo $grid->createDataGrid($dbs, 'pendaftaran_mandiri');