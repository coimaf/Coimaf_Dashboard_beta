<nav aria-label="Page navigation" class="d-flex text-center justify-content-center">
    <ul class="pagination">
        {{ $props->links() }}
    </ul>
  </nav>


  <style>
    .pagination a{
    text-align: center;
    display: inline-block;
    border: 1px solid;
    cursor: pointer;
    position:relative;
    overflow:hidden;
    border-radius: 15px;
    text-decoration: none;
    color: var(--nero);
    padding: 5px 10px!important;
}

.pagination svg, .pagination span, .pagination p{
    display: none;
}
</style>