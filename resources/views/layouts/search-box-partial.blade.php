@php
$itemCategories = App\ItemCategory::all();
@endphp
<form action="{{ route('items.search') }}" method="get" class="item-search-form">
    <div class="form-group search-box">
       <div class="input-group custom_font">


            <input type="text" name="s" id="search_auto_complete" placeholder="Search Item " class="form-control search_input_height" autofocus
                   style="font-size: large" required/>
            <span class="input-group-addon" ><button class="btn"><span class="glyphicon glyphicon-search"></span></button></span>

        </div>

        <div class="input-group filter-selector">


                <span class="input-group-addon" ><i class="fa fa-filter"></i></span>
                <label for="category"></label>
                <select name="ctg" id="category" class="form-control">
                    <option value=""  disabled selected>All</option>
                    @foreach($itemCategories as $itemCategory)
                        <option value="{{ $itemCategory->id }}">{{ substr($itemCategory->name,0,20)  }}</option>
                    @endforeach
                </select>

        </div>

    </div>


</form>
<style>
    .filter-selector {
        width: 200px;
        margin: 5px 0 0 0;
    }
</style>
