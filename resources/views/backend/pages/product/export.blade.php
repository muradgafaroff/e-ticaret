<table>
    <thead>
    <tr>
        <th>Product Name</th>
        <th>Category Name</th>
        <th>Price</th>
        <th>Size</th>
        <th>Color</th>
    </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
        <tr>
            <td>{{ $product->name }}</td>
            <td>{{ $product->category->name }}</td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->size }}</td>
            <td>{{ $product->color }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
