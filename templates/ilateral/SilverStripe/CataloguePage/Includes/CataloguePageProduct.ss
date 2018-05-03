<div class="unit-33 col-md-4 col-sm-6 unit cataloguepage-product">
    <h2>
        <a href="$RelativeLink">
            $Title
        </a>
    </h2>

    <p class="image">
        <% if $SortedImages.First %>
            <a href="$Link">
                <% with $SortedImages.First.Fill(555,350) %>
                    <img src="$URL" title="$Title" alt="$Title" class="img-responsive img-fluid" />
                <% end_with %>
            </a>
        <% end_if %>
    </p>

    <div class="units-row end row units-mobile-50">
        <p class="unit-60 col-md-7 col-sm-6">
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
        
        <p class="unit-40 col-md-5 col-sm-6 text-right right">
            <a class="btn btn-olive btn-primary text-centered" href="$RelativeLink">View</a>
        </p>
    </div>
</div>
