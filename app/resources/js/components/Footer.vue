<template>
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <a href="#" class="text-2xl font-['Pacifico'] text-white mb-4 inline-block">МедИнформСистем</a>
                    <p class="text-gray-400 mb-4">Современная медицина для вашего здоровья</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="ri-telegram-fill"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="ri-vk-fill"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="ri-instagram-line"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <i class="ri-whatsapp-line"></i>
                        </a>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Навигация</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Главная</a></li>
                        <li><a href="#about" class="text-gray-400 hover:text-white transition">О нас</a></li>
                        <li><a href="#services" class="text-gray-400 hover:text-white transition">Услуги</a></li>
                        <li><a href="#doctors" class="text-gray-400 hover:text-white transition">Врачи</a></li>
                        <li><a href="#contacts" class="text-gray-400 hover:text-white transition">Контакты</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-4">Контакты</h3>
                    <ul class="space-y-2">
                        <li class="flex items-start">
                            <i class="ri-map-pin-line mr-2 mt-1 shrink-0"></i>
                            <span>г.Йошкар-Ола</span>
                        </li>
                        <li class="flex items-start">
                            <i class="ri-phone-line mr-2 mt-1 shrink-0"></i>
                            <span>+7 (123) 456-78-90</span>
                        </li>
                        <li class="flex items-start">
                            <i class="ri-mail-line mr-2 mt-1 shrink-0"></i>
                            <span>info@informsystem.qunexx.ru</span>
                        </li>
                        <li class="flex items-start">
                            <i class="ri-time-line mr-2 mt-1 shrink-0"></i>
                            <span>Пн-Сб: 8:00 - 18:00<br>Вс: выходной</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 mb-4 md:mb-0">© 2025 МедИнформСистем. Все права защищены.</p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white transition">Политика конфиденциальности</a>
                    <a href="#" class="text-gray-400 hover:text-white transition">Условия использования</a>
                </div>
            </div>
        </div>
    </footer>
</template>

<script setup lang="ts">

</script>

<style scoped>
.font-\[\'Pacifico\'\] {
    font-family: 'Pacifico', cursive;
}

</style>
