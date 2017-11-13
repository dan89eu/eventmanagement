<li class="{{ Request::is('admin/events*') ? 'active' : '' }}">
    <a href="{!! route('admin.events.index') !!}">
    <i class="livicon" data-c="#EF6F6C" data-hc="#EF6F6C" data-name="$ICON_NAME$" data-size="18"
               data-loop="true"></i>
               Events
    </a>
</li>

<li class="{{ Request::is('admin/categories*') ? 'active' : '' }}">
    <a href="{!! route('admin.categories.index') !!}">
    <i class="livicon" data-c="#EF6F6C" data-hc="#EF6F6C" data-name="$ICON_NAME$" data-size="18"
               data-loop="true"></i>
               Categories
    </a>
</li>

<li class="{{ Request::is('admin/campaigns*') ? 'active' : '' }}">
    <a href="{!! route('admin.campaigns.index') !!}">
    <i class="livicon" data-c="#EF6F6C" data-hc="#EF6F6C" data-name="$ICON_NAME$" data-size="18"
               data-loop="true"></i>
               Campaigns
    </a>
</li>

<li class="{{ Request::is('admin/contacts*') ? 'active' : '' }}">
    <a href="{!! route('admin.contacts.index') !!}">
    <i class="livicon" data-c="#EF6F6C" data-hc="#EF6F6C" data-name="$ICON_NAME$" data-size="18"
               data-loop="true"></i>
               Contacts
    </a>
</li>

<li class="{{ Request::is('admin/eventDates*') ? 'active' : '' }}">
    <a href="{!! route('admin.eventDates.index') !!}">
    <i class="livicon" data-c="#EF6F6C" data-hc="#EF6F6C" data-name="$ICON_NAME$" data-size="18"
               data-loop="true"></i>
               EventDates
    </a>
</li>

<li class="{{ Request::is('admin/contactEvents*') ? 'active' : '' }}">
    <a href="{!! route('admin.contactEvents.index') !!}">
    <i class="livicon" data-c="#EF6F6C" data-hc="#EF6F6C" data-name="$ICON_NAME$" data-size="18"
               data-loop="true"></i>
               Contact_events
    </a>
</li>

<li class="{{ Request::is('admin/eventStatuses*') ? 'active' : '' }}">
    <a href="{!! route('admin.eventStatuses.index') !!}">
    <i class="livicon" data-c="#EF6F6C" data-hc="#EF6F6C" data-name="$ICON_NAME$" data-size="18"
               data-loop="true"></i>
               EventStatuses
    </a>
</li>

<li class="{{ Request::is('admin/emails*') ? 'active' : '' }}">
    <a href="{!! route('admin.emails.index') !!}">
    <i class="livicon" data-c="#EF6F6C" data-hc="#EF6F6C" data-name="$ICON_NAME$" data-size="18"
               data-loop="true"></i>
               Emails
    </a>
</li>

