<template>
    <Button v-bind="$attrs"
            :aria-label="Lang.get('main.buttons.send-feedback')"
            :label="Lang.get('main.buttons.send-feedback')"
            icon="fa-regular fa-comment-dots"
            @click="showFeedbackDialog = true"
    />
    <FeedbackDialog v-if="showFeedbackDialog"
                    class="max-w-xl"
                    position="top"
                    @closed="showFeedbackDialog = false"
                    @saved="showFeedbackDialog = false"
    />
</template>

<script setup>
import FeedbackDialog from '../dialogs/FeedbackDialog.vue'
import { ref } from 'vue'

defineOptions({
    inheritAttrs: false
})

const showFeedbackDialog = ref(false)
</script>
