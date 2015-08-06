<div class="unit-50 unit cataloguepage-product">
    <h2>
        <a href="$Link">
            $Title
        </a>
    </h2>

    <p class="image">
        <a href="$Link">$SortedImages.First.CroppedImage(555,350)</a>
    </p>

    <div class="units-row end units-mobile-50">
        <p class="unit-60">
            <strong class="price">
                <% if $IncludesTax %>
                    {$PriceAndTax.nice}
                <% else %>
                    {$Price.nice}
                <% end_if %>
            </strong>
            
            <span class="tax">
                <% if $TaxString %>
                    <span class="tax"> 
                        {$TaxString}
                    </span>
                <% end_if %>
            </span>
        </p>
        
        <p class="unit-40 right">
            <a class="btn btn-olive text-centered" href="$Link">View</a>
        </p>
    </div>
</div>
