<?php
use App\Helpers\UserContext;
use App\Helpers\ViewHelper;
//TODO: set the page title dynamically based on the view being rendered in the controller.
$page_title = 'Welcome to KVC Manager!';
ViewHelper::loadHeader($page_title);
ViewHelper::loadHeader($page_title, true);
ViewHelper::loadSideBar();

$user = UserContext::getCurrentUser();

$isAdmin = $data['isAdmin'] ?? false;
$show_variant_search = $show_variant_search ?? false;

$pallets = $data['pallets'] ?? [];
$team_members = $data['team_members'] ?? [];

$variants = $data['variants'] ?? [];

$show_form_end = $data['show_form_end'] ?? false;

$station = $data['station'] ?? null;

$total = count($pallets);
$i = 0;

$show_pallet_edit = $data['show_pallet_edit'] ?? false;
$pallet_to_edit = $data['pallet'] ?? null;

$totes = $data['totes'] ?? [];
$stations = $data['stations'] ?? [];

$show_break_continue = $data['show_break_continue'] ?? null;

//var_dump($station);
//var_dump($user);
function fmt_time(?string $ts): string {
    if (empty($ts)) return '';
    try {
        $dt = new \DateTime($ts);
        return $dt->format('H:i');
    } catch (\Exception $e) {
        return htmlspecialchars($ts);
    }
}

?>
<main id="work-page">

    <?php if ($isAdmin): ?>
        <form method="GET" action="<?= APP_BASE_URL ?>/work">
            <label for="station_id">Station:</label>
            <select name="station_id" id="station_id" onchange="this.form.submit()">
                <?php foreach ($stations as $s): ?>
                    <option value="<?= $s['station_id'] ?>"
                        <?= $s['station_id'] == $selectedStationId ? 'selected' : '' ?>>
                        <?= htmlspecialchars($s['station_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>
    <?php endif; ?>

    <section id="work-header">
        <h1 style="color: white;">
            <?= !empty($station['station_name'])
                ? htmlspecialchars($station['station_name'])
                : 'No station selected' ?>
        </h1>

        <div id="team-members">
            <strong style="font-size: 30px;">Team Members:</strong>
            <span style="font-size: 25px;">
                <?php foreach ($team_members as $key => $member): ?>
                    <?php echo $member['first_name'] ?>
                <?php endforeach; ?>
            </span>
        </div>

        <?= App\Helpers\FlashMessage::render() ?>
    </section>

    <section id="work-table-section">
        <table id="work-table" border="1" cellpadding="6" cellspacing="0">
            <thead>

                <tr>
                    <th>Product</th>
                    <th>Batch #</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Units</th>
                    <th>Breaks</th>
                    <th>Mess</th>
                    <th>Notes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pallets as $key => $pallet):
                    $i++;
                    if ($i === $total && $show_form_end) { ?>
                        <tr>
                            <form action="<?= APP_BASE_URL ?>/work/end" method="POST">
                                <input type="hidden" name="session_id" value="<?= $pallet['session_id']?>">
                                <td><?= $pallet['variant_description']?></td>
                                <td><?= $pallet['batch_number']?></td>
                                <td><?= fmt_time($pallet['start_time'])?></td>
                                <td><button type="submit" action="action" value="end">End</button></td>
                                <td><input name="units" type="text" placeholder="enter amt"></td>
                                <td>
                                    <button type="submit" name="action" value="break">
                                        <?= $show_break_continue ? 'Continue' : 'Break' ?>
                                    </button>
                                </td>
                                <td><input name="mess" type="checkbox"></td>
                                <td><input name="notes" type="text" placeholder="additional notes"></td>
                            </form>
                        </tr>
                  <?php  } else { ?>
                    <tr>
                        <td><?= $pallet['variant_description']?></td>
                        <td><?= $pallet['batch_number']?></td>
                        <td><?= fmt_time($pallet['start_time'])?></td>
                        <td><?= fmt_time($pallet['end_time'])?></td>
                        <td><?= $pallet['units']?></td>
                        <td><?= $pallet['break_time']?></td>
                        <td><input type="checkbox" <?= $pallet['mess'] ? 'checked' : '' ?> disabled></td>
                        <td><?= $pallet['notes']?></td>
                        <td>
                            <form method="GET" action="<?= APP_BASE_URL ?>/work/edit/<?= $pallet['pallet_id'] ?>" style="display:inline">
                                <button type="submit">Edit</button>
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                <?php endforeach; ?>

                <?php if (!$show_form_end) {?>
                    <tr>
                        <form action="<?= APP_BASE_URL ?>/work/start" method="POST">
                        <td>
                            <input type="hidden" name="station_id" value="<?= $station['station_id'] ?? ''?>">
                            <input id="variant_display" type="text" name="variant_display" value="" readonly>
                            <input type="hidden" id="variant_id_hidden" name="variant_id" value="">
                            <a href="<?=APP_BASE_URL ?>/work/search">Search Product</a>
                        </td>
                        <td>
                            <input id="batch_number" name="batch_number" type="text" value="">
                        </td>
                        <td>
                            <div>
                                <button type="submit">Start</button>
                            </div>
                        </td>
                        </form>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </section>
</main>

<!-- SEARCH PRODUCT VARIANT POPUP -->
 <?php
 if ($show_variant_search):?>
<div id="forgotPasswordModal" class="forgot-modal-overlay">
    <div class="forgot-modal-box">
        <a href="<?=APP_BASE_URL ?>/work" class="close-forgot">X</a>
        <h2>Search Product Variant</h2>
        <form action="<?= APP_BASE_URL ?>/admin/type/edit/<?= $product_type_to_edit['product_type_id'] ?>" method="POST">
        <input type="hidden" value="<?= $product_type_to_edit['product_type_id'] ?>" name="product_type_id">
            <input value="" name="variant_search" type="text" placeholder="Enter Product Variant">
            <div class="search-results"></div>
            <div class="default-variants">
                <?php foreach ($variants as $key => $variant): ?>
                    <div class="variant-row">
                        <button type="button"
                                class="variant-select-btn"
                                data-variant-id="<?= $variant['variant_id'] ?>"
                                data-variant-name="<?= $variant['variant_description'] ?>">
                            <?= $variant['variant_description'] ?>
                        </button>
                    </div>
                <?php endforeach; ?>
            </div>
            <input type="hidden" id="variant_id_hidden" name="variant_id" value="">
            <span id="variant_display"></span>
            <a href="<?=APP_BASE_URL ?>/work">Cancel</a>
        </form>

    </div>
</div>
<?php endif; ?>

<!-- EDIT PALLET POPUP -->
 <?php
 if ($show_pallet_edit):?>
<div id="forgotPasswordModal" class="forgot-modal-overlay">
    <div class="forgot-modal-box">
        <a href="<?=APP_BASE_URL ?>/work" class="close-forgot">X</a>
        <h2>Edit Pallet</h2>
        <form action="<?= APP_BASE_URL ?>/work/edit/<?= $pallet_to_edit['pallet_id'] ?>" method="POST">
        <input type="hidden" value="<?= $pallet_to_edit['pallet_id'] ?>" name="pallet_id">
        <div class="quick-add-title">Quick Add :</div>

            <label for="">Tote</label>
            <select name="tote_id" class="form-select" id="product_type_id">
                <option value="<?= $pallet_to_edit['tote_id'] ?>"><?= $pallet_to_edit['tote_id'] ?></option>
                <?php foreach ($totes as $tote): ?>
                    <option value="<?= $tote['tote_id'] ?>">
                        <?= $tote['batch_number'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="">Station</label>
            <select name="station_id" class="form-select" id="product_type_id">
                <option value="<?= $pallet_to_edit['station_id'] ?>"><?= $pallet_to_edit['station_id'] ?></option>
                <?php foreach ($stations as $station): ?>
                    <option value="<?= $station['station_id'] ?? '' ?>">
                        <?= $station['station_name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="start_time">Start Time</label>
            <input value="<?= $pallet_to_edit['start_time'] ?>" name="start_time" type="text" placeholder="Enter Start Time">

            <label for="end_time">End Time</label>
            <input value="<?= $pallet_to_edit['end_time'] ?>" name="end_time" type="text" placeholder="Enter End Time">

            <label for="units">Units</label>
            <input value="<?= $pallet_to_edit['units'] ?>" name="units" type="text" placeholder="Enter Units">

            <label for="break_time">Break Time</label>
            <input value="<?= $pallet_to_edit['break_time'] ?>" name="break_time" type="text" placeholder="Enter Break Time">

            <label for="mess">Break Time</label>
            <input value="<?= $pallet_to_edit['mess'] ?>" name="mess" type="button">

            <label for="notes">Notes</label>
            <input value="<?= $pallet_to_edit['notes'] ?>" name="notes" type="text" placeholder="Enter Notes">

            <button type="submit">Update Pallet</button>
            <a href="<?=APP_BASE_URL ?>/admin">Cancel</a>
        </form>

    </div>
</div>
<?php endif; ?>

<script src="/kvc-manager/public/assets/js/work-log-page.js"></script>
<?php
ViewHelper::loadFooter();
?>
