@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Mental Health Resources</h1>
    <p>Here you can find a collection of resources aimed at providing support for mental health and well-being, specifically curated for our community in the UK.</p>
    
    <section>
        <h2>Emergency Hotlines and Textlines</h2>
        <ul>
            <li>Samaritans: Call 116 123 (free, available 24/7)</li>
            <li>Crisis Text Line UK: Text "SHOUT" to 85258 (free, available 24/7)</li>
            <li>Mind Infoline: Call 0300 123 3393 (information on mental health issues)</li>
        </ul>
    </section>
    
    <section>
        <h2>Support for Bereavement</h2>
        <ul>
            <li>Cruse Bereavement Care: Call 0808 808 1677</li>
            <li>The Compassionate Friends: Offering support after the death of a child/children</li>
        </ul>
    </section>

    <section>
        <h2>Family and Relationship Concerns</h2>
        <ul>
            <li>Relate: The relationship people (offers advice on relationships, family life, and marriage)</li>
            <li>Family Lives: Call 0808 800 2222 (advice on all aspects of family life)</li>
        </ul>
    </section>

    <section>
        <h2>Financial and Money Concerns</h2>
        <ul>
            <li>StepChange Debt Charity: Call 0800 138 1111 (free debt advice)</li>
            <li>National Debtline: Call 0808 808 4000 (free advice on debt and financial issues)</li>
        </ul>
    </section>

    <section>
        <h2>Concerns Related to Studies and Academic Stress</h2>
        <ul>
            <li>Student Minds: The UK's student mental health charity</li>
            <li>Nightline: Confidential listening and support service run by students for students</li>
        </ul>
    </section>
    
    <section>
        <h2>Articles, Guides, and Tools</h2>
        <p>Explore a range of informative articles and practical guides to help manage and understand various mental health concerns:</p>
        <ul>
            <li><a href="https://www.mind.org.uk/information-support/">Mind: Information & Support</a></li>
            <li><a href="https://www.nhs.uk/conditions/stress-anxiety-depression/">NHS: Mental Health</a></li>
        </ul>
    </section>
    <section>
        <h2>Book an Appointment</h2>
        <form action="{{ route('appointments.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="professional_id">Select Professional:</label>
                <select id="professional_id" name="professional_id" class="form-control">
                    {{-- Assume you pass a $professionals variable to the view --}}
                    @foreach($professionals as $professional)
                        <option value="{{ $professional->id }}">{{ $professional->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="appointment_time">Appointment Time:</label>
                <input type="datetime-local" id="appointment_time" name="appointment_time" class="form-control">
            </div>
            <div class="form-group">
                <label for="notes">Notes (optional):</label>
                <textarea id="notes" name="notes" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Book Appointment</button>
        </form>
    </section>

</div>
@endsection
