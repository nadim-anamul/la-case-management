@extends('layouts.app')

@section('title', 'সকল আদেশপত্র')

@section('content')
    <div class="container mx-auto p-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">সকল আদেশপত্র</h1>
            <a href="{{ route('order.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + নতুন আদেশপত্র যোগ করুন
            </a>
        </div>

        <!-- Search Form -->
        <form action="{{ route('order.index') }}" method="GET" class="mb-6">
            <div class="flex items-center max-w-lg ml-auto justify-end">
                <input type="text" name="search" placeholder="মামলার নং বা আবেদনকারী দিয়ে খুঁজুন..." class="w-full px-4 py-2 border rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ $search ?? '' }}">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-r-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">খুঁজুন</button>
            </div>
        </form>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{!! session('success') !!}</span>
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">মামলার নং</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">আবেদনকারী</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">তারিখ</th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-50"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ $order->id }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ $order->case_number }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ Str::limit($order->applicant_name, 50) }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ \Carbon\Carbon::parse($order->order_date)->format('d-M-Y') }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-right whitespace-nowrap">
                            <a href="{{ route('order.preview', $order->id) }}" target="_blank" class="text-green-600 hover:text-green-900 mr-3">Preview</a>
                            <a href="{{ route('order.pdf', $order->id) }}" target="_blank" class="text-blue-600 hover:text-blue-900 mr-3">Download PDF</a>
                            <a href="{{ route('order.edit', $order->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                            <form action="{{ route('order.destroy', $order->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-10">
                            <p class="text-gray-600">কোনো আদেশ পাওয়া যায়নি। 
                                @if($search)
                                    "{{ $search }}" লিখে খোঁজার পরও কিছু পাওয়া যায়নি।
                                @endif
                            </p>
                            <a href="{{ route('order.index') }}" class="text-blue-600 underline mt-2 inline-block">সকল আদেশ দেখুন</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-8">
            {{ $orders->appends(['search' => $search])->links() }}
        </div>
    </div>
@endsection