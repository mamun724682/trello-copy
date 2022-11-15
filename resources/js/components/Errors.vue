<template>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <span v-if="!content.errors">{{ content.message }}</span>
        <div v-else>
            <ul>
                <li v-for="error in content.errors" :key="error.index">
                    <ul>
                        <li v-for="e in error" :key="e.index">
                            {{ e }}
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

        <button type="button" @click="$emit('close')" class="close border-0 float-end" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
</template>


<script>
export default {
    props: {
        type: {
            type: String,
            default: "success",
        },
        content: {
            type: Object,
            default: "hello !",
        },
    },
};
</script>
