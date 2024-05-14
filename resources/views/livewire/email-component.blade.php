 <div class="container w-full md:max-w-3xl mx-auto pt-20">
        <div class="text-gray-700">
            <label for="subject">Subject:</label>
            <span id="subject">{{ $email->subject }}</span>
        </div>
        <div class="text-gray-700 pt-4">
            <label for="sender">Sender:</label>
            <span id="sender">{{ $email->sender_address }}</span>
        </div>
        <div class="text-gray-700 pt-4">
            <label for="recipient">Recipient:</label>
            <span id="recipient">{{ $email->recipient_address }}</span>
        </div>
        <div class="text-gray-700 mt-4 border rounded border-gray-200 overflow-y-auto h-80">
            {{-- Here I prefer to output the plain body if we have one for because it looks better considering we don't actually want to just output unescaped code. --}}
            <div id="body" class="p-8" aria-label="body">{{ $email->body_plain ?? strip_tags($email->body) }}</div>
        </div>
        @if($email->attachments !== null)
            <div class="text-gray-700 pt-10">
                <label for="attachments">Attachments:</label>
                <ul id="attachments">
                    @foreach($email->attachments as $attachment)
                        <li>{{ $attachment }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="text-gray-700 pt-4">
            <label for="tag_input" class="mr-3">Add Tag</label>
            <input id="tag_input" type="text" class="mr-3" wire:model="tag" >
            <button wire:click="saveTag">Save</button>
        </div>
        @if($email->tags !== null)
            <div class="text-gray-700 pt-4">
                <label for="tags">Tags</label>
                <ul>
                    @foreach($email->tags as $tag)
                        <li>{{ $tag }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
