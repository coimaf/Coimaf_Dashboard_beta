<button type="{{$type}}" class="btn bg-primary-cust text-white btn-cust fs-5 me-2">{{ $props }}</button>

<style>
    .btn-cust{
        font-size: 10px;
        margin: 3px;
    }
    .btn-cust:hover{
        background-color: var(--bg-primary-cust-hover)
    }
</style>