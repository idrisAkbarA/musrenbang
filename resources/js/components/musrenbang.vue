<template>
    <v-container>
        <v-row class="mb-3">
            <v-col cols="12">
                <v-hover>
                    <template v-slot="{ hover }">
                        <v-card max-height="50" class="prioritas" :elevation="hover ? 17 : 6">
                            <v-card dark class="d-flex justify-center
                            align-self-center kelA" color="blue" max-width="150" height="30">
                                <span class="mt-1">
                                    Kelurahan Angin
                                </span>
                            </v-card>
                            <v-row style="margin-top:-40px">
                                <v-col cols="3">
                                    <v-card-text>Test</v-card-text>
                                </v-col>
                                <v-col cols="3">
                                    <v-card-text>Test</v-card-text>
                                </v-col>
                                <v-col cols="3">
                                    <v-card-text>Test</v-card-text>
                                </v-col>
                                <v-col cols="3">
                                    <v-card-text>Test</v-card-text>
                                </v-col>
                            </v-row>
                        </v-card>
                    </template>
                </v-hover>
            </v-col>
        </v-row>
        <div style="bottom:0; position:fixed;">
            <v-row>
                <v-col cols="12">
                    <v-hover>
                        <template v-slot="{ hover }">
                            <v-card width="400" class="d-flex" :elevation="hover ? 17 : 6">
                                <v-card-text>
                                    baris per halaman 5
                                </v-card-text>
                                <v-divider vertical></v-divider>
                                <v-card-text> 1 - 5 dari 10</v-card-text>
                                <div class="mt-2">
                                    <v-btn icon>
                                        <v-icon>keyboard_arrow_left</v-icon>
                                    </v-btn>
                                    <v-btn icon>
                                        <v-icon>keyboard_arrow_right</v-icon>
                                    </v-btn>
                                </div>
                            </v-card>
                        </template>
                    </v-hover>
                </v-col>
            </v-row>
        </div>
    </v-container>
</template>
<style scoped>
    .kelA {
        left: 10px;
        top: -18px;
        position: relative;
    }

    .prioritas {
        border-left: 6px solid orange;
    }

</style>

<script>
    export default {
        data: () => ({

        }),
    }

</script>
