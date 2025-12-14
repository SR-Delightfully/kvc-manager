<!-- TODO: create admin/products view -->
<!-- TODO: define admin/products overview -->
<!-- TODO: move big products table to this file -->
<!-- TODO: move big product_type table to this file -->
<!-- TODO: move big product_variant table to this file -->
<div class="dashboard-section">


<!-- Product_Types Table -->
<!-- Products Table -->
<h2 style="color: white;">Products</h2>
<div class="table-responsive small">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Product Type</th>
                <th scope="col">Code</th>
                <th scope="col">Name</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $key => $product): ?>
                <tr>
                    <td><?= $product['product_id']?></td>
                    <td><?= $product['product_type_id']?></td>
                    <td><?= $product['product_code']?></td>
                    <td><?= $product['product_name']?></td>
                    <td>
                        <a class="btn btn-secondary" href="admin/product/edit/<?=$product['product_id']?>">Edit</a>
                        <a class="btn btn-danger" href="admin/product/delete/<?=$product['product_id']?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


<h2 style="color: white;">Product Types</h2>
<!-- Types Table -->
<div class="table-responsive small">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Product Type</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($product_types as $key => $type): ?>
                <tr>
                    <td><?= $type['product_type_id']?></td>
                    <td><?= $type['product_type_name']?></td>
                    <td>
                        <a class="btn btn-secondary" href="admin/type/edit/<?=$type['product_type_id']?>">Edit</a>
                        <a class="btn btn-danger" href="admin/type/delete/<?=$type['product_type_id']?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


<h2 style="color: white;">Colours</h2>
<!-- Colours Table -->
<div class="table-responsive small">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Colour Code</th>
                <th scope="col">Colour Name</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($colours as $key => $colour): ?>
                <tr>
                    <td><?= $colour['colour_code']?></td>
                    <td><?= $colour['colour_name']?></td>
                    <td>
                        <a class="btn btn-secondary" href="admin/colour/edit/<?=$colour['colour_id']?>">Edit</a>
                        <a class="btn btn-danger" href="admin/colour/delete/<?=$colour['colour_id']?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Variants Table -->
<h2 style="color: white;">Product Variants</h2>
<div class="table-responsive small">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Product Id</th>
                <th scope="col">Colour Id</th>
                <th scope="col">Unit Size</th>
                <th scope="col">Description</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($variants as $key => $variant): ?>
                <tr>
                    <td><?= $variant['variant_id']?></td>
                    <td><?= $variant['product_id']?></td>
                    <td><?= $variant['colour_id']?></td>
                    <td><?= $variant['unit_size']?></td>
                    <td><?= $variant['variant_description']?></td>
                    <td>
                        <a class="btn btn-secondary" href="admin/variant/edit/<?=$variant['variant_id']?>">Edit</a>
                        <a class="btn btn-danger" href="admin/variant/delete/<?=$variant['variant_id']?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


</div>
