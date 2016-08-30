<br>

<div class="form-group">
    <div class="fg-line">
      <label class="fg-label">Mobile Phone</label>
      <input type="text" class="form-control" name="phone" id="phone" value="{{ $data['phone'] }}" placeholder="Mobile Phone">
    </div>
</div>

<br>

<div class="form-group">
    <div class="fg-line">
      <label class="fg-label">Email Address</label>
      <input type="email" class="form-control" name="email" id="email" value="{{ $data['email'] }}" placeholder="Email Address">
    </div>
</div>

<br>

<div class="form-group">
    <div class="fg-line">
      <label class="fg-label">Twitter</label>
      <input type="text" class="form-control" name="twitter" id="twitter" value="{{ $data['twitter'] }}" placeholder="Twitter Username">
    </div>
</div>

<br>

<div class="form-group">
    <div class="fg-line">
      <label class="fg-label">Facebook</label>
      <input type="text" class="form-control" name="facebook" id="facebook" value="{{ $data['facebook'] }}" placeholder="Facebook Username">
    </div>
</div>

<br>

<div class="form-group">
    <div class="fg-line">
      <label class="fg-label">GitHub</label>
      <input type="text" class="form-control" name="github" id="github" value="{{ $data['github'] }}" placeholder="GitHub Username">
    </div>
</div>

<br>

<div class="form-group">
    <div class="fg-line">
      <label class="fg-label">LinkedIn</label>
      <input type="text" class="form-control" name="linkedin" id="linkedin" value="{{ $data['linkedin'] }}" placeholder="LinkedIn Username">
    </div>
</div>

<br>

<div class="form-group">
    <div class="fg-line">
        <label class="fg-label">Resume/CV <a href="" data-toggle="modal" data-target="#resume-help"><i class="zmdi zmdi-help" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Resume/CV Help"></i></a></label>
        <input type="text" class="form-control" name="resume_cv" id="resume_cv" value="{{ $data['resume_cv'] }}" placeholder="Example: my_resume.pdf">
    </div>
</div>

<br>

<div class="form-group">
    <div class="fg-line">
      <label class="fg-label">Address</label>
      <input type="text" class="form-control" name="address" id="address" value="{{ $data['address'] }}" placeholder="Address">
    </div>
</div>

<br>

<div class="form-group">
    <div class="fg-line">
      <label class="fg-label">City</label>
      <input type="text" class="form-control" name="city" id="city" value="{{ $data['city'] }}" placeholder="City">
    </div>
</div>

<br>

<div class="form-group">
    <div class="fg-line">
      <label class="fg-label">Country</label>
      <input type="text" class="form-control" name="country" id="country" value="{{ $data['country'] }}" placeholder="Country">
    </div>
</div>

@include('backend.profile.partials.modals.resume-help')