<div class="catalogue-content-container container catalogue-product typography">
    <article>
        <h1>$Title</h1>
        <div class="content">
            $Content
        </div>
    </article>
    
    <div class="units-row line cataloguepage-products">
        <% if $CompiledProducts %>
            <div class="row line catalogue-list">
                <% loop $CompiledProducts %>
                    <% include ilateral\\SilverStripe\\CataloguePage\\CataloguePageProduct %>

                    <% if $MultipleOf(3) && not $Last %></div><div class="row catalogue-list"><% end_if %>
                <% end_loop %>
            </div>

            <% with $CompiledProducts %>
                <div class="text-center">
                    <% if $MoreThanOnePage %>
                        <ul class="pagination line">
                            <% if $NotFirstPage %>
                                <li class="prev unit">
                                    <a class="prev" href="$PrevLink">Prev</a>
                                </li>
                            <% end_if %>

                            <% loop $Pages %>
                                <% if $CurrentBool %>
                                    <li class="unit active"><span>$PageNum</span></li>
                                <% else %>
                                    <% if $Link %>
                                        <li class="unit"><a href="$Link">$PageNum</a></li>
                                    <% else %>
                                        <li class="unit">...</li>
                                    <% end_if %>
                                <% end_if %>
                            <% end_loop %>

                            <% if $NotLastPage %>
                                <li class="unit next">
                                    <a class="next" href="$NextLink">Next</a>
                                </li>
                            <% end_if %>
                        </ul>
                    <% end_if %>
                </div>
            <% end_with %>
        <% else_if $Categories.exists %>
            <% loop $Categories %>
                <% if $Up.Categories.Count > 1 %>
                    <h2>$Title</h2>
                    
                    <hr />
                <% end_if %>
                <% if $SortedProducts.exists %>
                    <div class="units-row row line cataloguepage-products">
                        <% loop $SortedProducts %>
                            <% include ilateral\\SilverStripe\\CataloguePage\\CataloguePageProduct %>
                            
                            <% if $MultipleOf(2) && not $Last %>
                                </div><div class="units-row row line cataloguepage-products">
                            <% end_if %>
                        <% end_loop %>
                    </div>
                <% end_if %>
            <% end_loop %>
        <% else %>
            <% loop $SortedProducts %>
                <% include ilateral\\SilverStripe\\CataloguePage\\CataloguePageProduct %>
                
                <% if $MultipleOf(2) && not $Last %>
                    </div><div class="units-row row line cataloguepage-products">
                <% end_if %>
            <% end_loop %>
        <% end_if %>
    </div>
</div>
