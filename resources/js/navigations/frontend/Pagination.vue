
<template>
    <nav class="pagination is-centered is-rounded cdp" 
        role="navigation" 
        aria-label="pagination"
    >
        <a class="pagination-previous cdp_i" 
            @click.prevent="changePage(1)" 
            v-show="pagination.meta.current_page > 1"
        >
            First
        </a>
        <a class="pagination-previous cdp_i" 
            @click.prevent="changePage(pagination.meta.current_page - 1)" 
            v-show="pagination.meta.current_page > 1"
        >
            Previous
        </a>
        <ul class="pagination-list">
            <li class="page-numbers" 
                v-for="(page, index) in pages" 
                :key="index"
            >
                <a class="pagination-link cdp_i" 
                    :class="isCurrentPage(page) ? 'is-current' : ''" 
                    @click.prevent="changePage(page)"
                >
                    {{ page }}
                </a>
            </li>
        </ul>
        <a class="pagination-next cdp_i" 
            @click.prevent="changePage(pagination.meta.current_page + 1)" 
            v-show="pagination.meta.current_page < pagination.meta.last_page"
        >
            Next
        </a>
        <a class="pagination-next cdp_i" 
            @click.prevent="changePage(pagination.meta.last_page)" 
            v-show="pagination.meta.current_page < pagination.meta.last_page"
        >
            Last
        </a>
    </nav>
</template>

<script>
    export default {
        props: ['pagination', 'offset'],
        methods: {
            isCurrentPage(page) {
                return this.pagination.meta.current_page === page;
            },
            changePage(page) {
                if (page > this.pagination.meta.last_page) {
                    page = this.pagination.meta.last_page;
                }
                this.pagination.meta.current_page = page;
                this.$emit('paginate');
            }
        },
        computed: {
            pages() {
                let pages = [];
                let from = this.pagination.meta.current_page - Math.floor(this.offset / 2);
                if (from < 1) {
                    from = 1;
                }
                let to = from + this.offset - 1;
                if (to > this.pagination.meta.last_page) {
                    to = this.pagination.meta.last_page;
                }
                while (from <= to) {
                    pages.push(from);
                    from++;
                }
                return pages;
            }
        }
    }
</script>

<style lang="scss" scoped>
    .pagination {
        margin-top: 40px;
    }

    .pagination-list {
        display: inline-flex;
    }

    @keyframes cdp-in {
        from {
            transform: scale(1.5);
            opacity: 0;
        }
        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    .cdp {
    position: relative;
    text-align: center;
    justify-content: center;
    padding: 20px 0;
    font-size: 0;
    z-index: 6;
    margin: 50px 0;
    
    animation: cdp-in 500ms ease both;

    @media screen and (max-width: 787px) {
        margin: 0 0;
        margin-top:0; 
    }

    &_i {
        font-size: 14px;
        text-decoration: none;
        transition: background 250ms;
        display: inline-block;
        text-transform: uppercase;
        margin: 0 3px 6px;
        height: 38px;
        min-width: 38px;
        border-radius: 38px;
        border: 2px solid #9e9e9e;
        line-height: 35px;
        padding: 0;
        color: #fff;
        font-weight: 700;
        letter-spacing: .03em;
        display: none;
        background: #ffffff;

        &:first-child,
        &:last-child,
        &:nth-child(2),
        &:nth-last-child(2) {
        padding: 0 16px;
        margin: 0 12px 6px;
        }

        &:last-child,
        &:nth-child(2),
        &:nth-last-child(2) {
        display: inline-block;
        }
    }

    &_i:hover {
        background-color: #ff5757;
        color: #fff;
        border-color: #ff5757;
    }

    &:not([is-current]) &_i:nth-child(1) {
        display: inline-block;
    }

    .is-current {
        background-color: #0b7ddc;
        color: #f8f9fa;
        border-color: #0b7ddc;
    }
    @media (max-width: 787px) {
        .cdp_i:first-child, 
        .cdp_i:last-child, .cdp_i:nth-child(2), 
        .cdp_i:nth-last-child(2) {
            padding: 0 5px;
            margin: 0 3px 6px;
        }
        ul {
            margin-bottom: 0;
        }
    }
}
</style>