<template>
    <v-card class="mr-10 mr-10 mb-5 ml-5 mt-10" flat tile min-width="">
        <v-hover>
            <template v-slot="{ hover }">
                <v-toolbar dense :elevation="hover ? 17 : 6">
                    <v-icon class="mr-2">home</v-icon>

                    <v-toolbar-title class="mt-1">Beranda</v-toolbar-title>

                    <v-spacer></v-spacer>

                    <v-chip class="mr-2" @click="3" label>
                        <v-icon left>event</v-icon>
                        <span class="mt-1">
                            T.A. 2021 MURNI
                        </span>
                    </v-chip>
                    <v-btn icon>
                        <v-icon>notifications</v-icon>
                    </v-btn>

                    <v-btn icon>
                        <v-icon>exit_to_app</v-icon>
                    </v-btn>
                </v-toolbar>
            </template>
        </v-hover>
    </v-card>
</template>
