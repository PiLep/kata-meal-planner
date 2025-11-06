<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="text-2xl font-bold mb-6">Today's Meals - {{ \Carbon\Carbon::parse($currentDate)->format('l, F j') }}</h2>

                @if($meals->count() > 0)
                    <div class="space-y-6">
                        @foreach($meals as $meal)
                            <div class="border rounded-lg p-4 hover:shadow-md transition">
                                <div class="flex items-start gap-4">
                                    @if($meal->recipe->image_url)
                                        <img src="{{ $meal->recipe->image_url }}"
                                             alt="{{ $meal->recipe->name }}"
                                             class="w-24 h-24 object-cover rounded-lg">
                                    @endif

                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <span class="inline-block px-3 py-1 bg-orange-100 text-orange-800 text-sm font-medium rounded-full mb-2">
                                                    {{ ucfirst($meal->meal_type) }}
                                                </span>
                                                <h3 class="text-lg font-semibold">{{ $meal->recipe->name }}</h3>
                                            </div>
                                        </div>

                                        <p class="text-gray-600 mt-2">{{ $meal->recipe->description }}</p>

                                        <div class="flex items-center gap-4 mt-3 text-sm text-gray-500">
                                            <span>Prep: {{ $meal->recipe->prep_time }} min</span>
                                            <span>Cook: {{ $meal->recipe->cook_time }} min</span>
                                            <span>Servings: {{ $meal->recipe->servings }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="text-gray-400 mb-4">
                            <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No meals planned for today</h3>
                        <p class="text-gray-500">Create a meal plan to get started!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
