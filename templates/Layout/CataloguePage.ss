<% include SideBar %>

<div class="content-container <% if $Menu(2) %>unit-75<% end_if %>">

    <article>
        <h1>$Title</h1>
        <div class="content">
            $Content
        </div>
    </article>
    
    <% loop $Categories %>
        <h2>$Title</h2>
        
        <hr />
        
        <% if $Products.exists %>
            <div class="units-row line cataloguepage-products">
                
                <% loop $Products %>
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
                    
                    <% if $MultipleOf(2) && not $Last %>
                        </div><div class="units-row line catalogue-list">
                    <% end_if %>
                <% end_loop %>
            </div>
        <% end_if %>
    <% end_loop %>
</div>
